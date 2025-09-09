document.addEventListener('DOMContentLoaded', function() {
  // --- DOM ELEMENTS ---
  const modal = document.getElementById('myModal');
  if (!modal) {
    console.error("Discord Modal (#myModal) not found.");
    return;
  }

  const openBtn = document.getElementById('openModalBtn');
  const closeButton = modal.querySelector('.close-button');
  const prevButton = modal.querySelector('.step-btn-prev');
  const nextButton = modal.querySelector('.step-btn-next');
  const submitButton = modal.querySelector('.step-btn-submit');
  const tabButtons = modal.querySelectorAll('.tab-button');

  const discordPreviewContainer = document.getElementById('discord-preview');
  const discordToggle = document.getElementById('discordToggle');
  const discordHint = document.getElementById('discord-hint');

  // Add an element to show inline validation messages
  let inlineChannelMsg = document.getElementById('discord-channel-msg');
  if (!inlineChannelMsg) {
    inlineChannelMsg = document.createElement('div');
    inlineChannelMsg.id = 'discord-channel-msg';
    inlineChannelMsg.style.color = 'red';
    inlineChannelMsg.style.fontSize = '0.95em';
    inlineChannelMsg.style.marginTop = '0.3em';
    inlineChannelMsg.style.display = 'none';
    // We'll append it dynamically below the select when needed
  }

  // Main hidden inputs
  const mainFields = [
    'enabled', 'type', 'channel', 'tag', 'title', 'description', 'embed_color'
  ];
  const mainDiscordInputs = {};
  mainFields.forEach(field => {
    mainDiscordInputs[field] = document.getElementById(`discord_${field}`);
  });

  const discordAppConfig = window.discordConfig || {
    channels: {},
    tags: {},
    defaultColor: '#3498db',
    botName: 'Discord Bot',
  };

  if (!openBtn) {
    console.error("Open Modal Button (#openModalBtn) not found.");
    return;
  }

  // ----- Helper Functions -----
  function getModalFieldId(field, type) {
    return `discord_${field}${type === 'embed' && ['channel', 'tag', 'title', 'description'].includes(field) ? '_embed' : ''}_modal`;
  }

  function getModalField(field, type) {
    return document.getElementById(getModalFieldId(field, type));
  }

  function setModalFieldsFromMain() {
    const type = mainDiscordInputs.type?.value || 'standard';
    ['channel', 'tag', 'title', 'description', 'embed_color'].forEach(field => {
      const input = getModalField(field, type);
      if (input && mainDiscordInputs[field]) {
        input.value = mainDiscordInputs[field].value || '';
      }
    });
  }

  function saveModalFieldsToMain() {
    const type = mainDiscordInputs.type?.value || 'standard';
    ['channel', 'tag', 'title', 'description'].forEach(field => {
      const input = getModalField(field, type);
      if (input && mainDiscordInputs[field]) {
        mainDiscordInputs[field].value = input.value || '';
      }
    });
    if (type === 'embed') {
      const colorInput = getModalField('embed_color', type);
      if (colorInput && mainDiscordInputs.embed_color) {
        mainDiscordInputs.embed_color.value = colorInput.value || discordAppConfig.defaultColor;
      }
    } else {
      if (mainDiscordInputs.embed_color) {
        mainDiscordInputs.embed_color.value = discordAppConfig.defaultColor;
      }
    }
  }

  function toggleFormControls(container, shouldDisable) {
    container.querySelectorAll('input:not([type="hidden"]), select, textarea')
      .forEach(control => control.disabled = shouldDisable);
  }

  function updateFormControlsState() {
    modal.querySelectorAll('.tab-content').forEach(tab => {
      const isTabActive = tab.classList.contains('active');
      tab.querySelectorAll('.step-page').forEach(step => {
        const isStepActive = step.classList.contains('active');
        toggleFormControls(step, !(isTabActive && isStepActive));
      });
    });
  }

  function getCurrentActiveStepInActiveTab() {
    const activeTab = modal.querySelector('.tab-content.active');
    return activeTab ? activeTab.querySelector('.step-page.active') : null;
  }

  function updateNavButtons() {
    const currentPage = getCurrentActiveStepInActiveTab();
    if (!currentPage || !prevButton || !nextButton || !submitButton) {
      prevButton && (prevButton.style.display = 'none');
      nextButton && (nextButton.style.display = 'none');
      submitButton && (submitButton.style.display = 'none');
      return;
    }
    const pageNum = parseInt(currentPage.getAttribute('data-page'));
    const totalPages = currentPage.parentElement.querySelectorAll('.step-page').length;
    prevButton.style.display = pageNum > 1 ? 'block' : 'none';
    nextButton.style.display = pageNum < totalPages ? 'block' : 'none';
    submitButton.style.display = pageNum === totalPages ? 'block' : 'none';
  }

  function updateMainPreview() {
    if (!mainDiscordInputs.type || !discordPreviewContainer) return;
    if (discordPreviewContainer.style.display === 'none' && discordToggle && !discordToggle.checked) return;

    const type = mainDiscordInputs.type.value || 'standard';
    const isEmbed = type === 'embed';
    const channel = mainDiscordInputs.channel.value || '';
    const tag = mainDiscordInputs.tag.value || '';
    const title = mainDiscordInputs.title.value || '';
    const description = mainDiscordInputs.description.value || '';
    const color = mainDiscordInputs.embed_color.value || discordAppConfig.defaultColor;

    // Tag
    const previewTagEl = document.getElementById('preview-tag');
    if (previewTagEl) {
      const tagData = discordAppConfig.tags[tag];
      previewTagEl.textContent = tagData ? tagData.name : (tag ? `@${tag}` : '');
      previewTagEl.style.display = tag ? 'block' : 'none';
    }
    // Channel
    const channelNameEl = discordPreviewContainer.querySelector('.channel-name');
    if (channelNameEl) {
      const channelData = discordAppConfig.channels[channel];
      channelNameEl.textContent = channelData ? `#${channelData.name}` : (channel ? `#${channel}` : '(Geen kanaal)');
    }

    // Standard vs Embed
    const previewStandardDiv = document.getElementById('preview-standard');
    const previewEmbedDiv = document.getElementById('preview-embed');
    if (isEmbed) {
      previewStandardDiv && (previewStandardDiv.style.display = 'none');
      previewEmbedDiv && (previewEmbedDiv.style.display = 'block');
      // Embed fields
      const colorBar = previewEmbedDiv.querySelector('.embed-color-bar');
      colorBar && (colorBar.style.backgroundColor = color);
      const embedTitleEl = previewEmbedDiv.querySelector('.embed-title');
      embedTitleEl && (embedTitleEl.textContent = title);
      const embedDescriptionEl = previewEmbedDiv.querySelector('.embed-description');
      if (embedDescriptionEl && typeof marked !== 'undefined') {
        embedDescriptionEl.innerHTML = description ? marked.parse(description) : '';
      } else if (embedDescriptionEl) {
        embedDescriptionEl.textContent = description;
      }
    } else {
      previewStandardDiv && (previewStandardDiv.style.display = 'block');
      previewEmbedDiv && (previewEmbedDiv.style.display = 'none');
      const messageTitleEl = document.getElementById('preview-title');
      messageTitleEl && (messageTitleEl.textContent = title);
      const messageDescriptionEl = document.getElementById('preview-description');
      if (messageDescriptionEl && typeof marked !== 'undefined') {
        messageDescriptionEl.innerHTML = description ? marked.parse(description) : '';
      } else if (messageDescriptionEl) {
        messageDescriptionEl.textContent = description;
      }
    }
    if (discordPreviewContainer && discordToggle) {
      discordPreviewContainer.style.display = discordToggle.checked ? 'block' : 'none';
    }
  }

  function closeModal() {
    modal.classList.remove("show-modal");
    setTimeout(() => modal.style.display = "none", 300);
  }

  // ----- Event Listeners -----
  openBtn.onclick = function(e) {
    e.preventDefault();
    setModalFieldsFromMain();
    modal.style.display = "flex";
    setTimeout(() => modal.classList.add("show-modal"), 10);
    updateNavButtons();
    updateFormControlsState();
  };

  closeButton && (closeButton.onclick = closeModal);
  window.onclick = (e) => { if (e.target === modal) closeModal(); };
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.classList.contains('show-modal')) closeModal();
  });

  submitButton && submitButton.addEventListener('click', function(e) {
    e.preventDefault();
    saveModalFieldsToMain();
    updateMainPreview();
    closeModal();
  });

  tabButtons.forEach(button => {
    button.onclick = () => {
      const tabId = button.getAttribute('data-tab');
      mainDiscordInputs.type && (mainDiscordInputs.type.value = tabId);
      tabButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
      modal.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
      const activeContent = modal.querySelector(`#${tabId}-content`);
      activeContent && activeContent.classList.add('active');
      activeContent && activeContent.querySelectorAll('.step-page').forEach((sp, idx) => sp.classList.toggle('active', idx === 0));
      setModalFieldsFromMain();
      updateNavButtons();
      updateFormControlsState();
    };
  });

  nextButton && (nextButton.onclick = () => {
    const currentPage = getCurrentActiveStepInActiveTab();
    if (!currentPage) return;
    const nextPage = currentPage.nextElementSibling;
    if (nextPage && nextPage.classList.contains('step-page')) {
      const currentPageNumber = parseInt(currentPage.dataset.page, 10);
      if (currentPageNumber === 1) {
        const activeTab = modal.querySelector('.tab-content.active');
        const channelSelect = activeTab.querySelector('select[id^="discord_channel"]');
        if (channelSelect && channelSelect.parentNode.contains(inlineChannelMsg)) {
          inlineChannelMsg.style.display = 'none';
        }
        if (!channelSelect || !channelSelect.value) {
          inlineChannelMsg.textContent = 'Selecteer een kanaal voordat je doorgaat.';
          inlineChannelMsg.style.display = 'block';
          if (channelSelect && !channelSelect.parentNode.contains(inlineChannelMsg)) {
            channelSelect.parentNode.appendChild(inlineChannelMsg);
          }
          channelSelect && channelSelect.focus();
          return;
        }
      }
      currentPage.classList.remove('active');
      nextPage.classList.add('active');
      updateNavButtons();
      updateFormControlsState();
    }
  });

  prevButton && (prevButton.onclick = () => {
    const currentPage = getCurrentActiveStepInActiveTab();
    if (!currentPage) return;
    const prevPage = currentPage.previousElementSibling;
    if (prevPage && prevPage.classList.contains('step-page')) {
      currentPage.classList.remove('active');
      prevPage.classList.add('active');
      updateNavButtons();
      updateFormControlsState();
    }
  });

  discordToggle && discordToggle.addEventListener('change', function() {
    const isChecked = this.checked;
    openBtn && (openBtn.disabled = !isChecked);
    mainDiscordInputs.enabled && (mainDiscordInputs.enabled.value = isChecked ? '1' : '0');
    discordHint && (discordHint.style.display = isChecked ? 'none' : 'block');
    discordPreviewContainer && (discordPreviewContainer.style.display = isChecked ? 'block' : 'none');
    if (!isChecked) {
      mainDiscordInputs.type && (mainDiscordInputs.type.value = 'standard');
      ['channel', 'tag', 'title', 'description'].forEach(f => mainDiscordInputs[f] && (mainDiscordInputs[f].value = ''));
      mainDiscordInputs.embed_color && (mainDiscordInputs.embed_color.value = discordAppConfig.defaultColor);
    }
    updateMainPreview();
  });

  // ----- Initialization -----
  if (discordToggle && mainDiscordInputs.enabled) {
    const isInitiallyEnabled = mainDiscordInputs.enabled.value === '1';
    discordToggle.checked = isInitiallyEnabled;
    openBtn && (openBtn.disabled = !isInitiallyEnabled);
    discordHint && (discordHint.style.display = isInitiallyEnabled ? 'none' : 'block');
    discordPreviewContainer && (discordPreviewContainer.style.display = isInitiallyEnabled ? 'block' : 'none');
  }

  if (mainDiscordInputs.type && tabButtons.length > 0) {
    const initialType = mainDiscordInputs.type.value || 'standard';
    let tabFound = false;
    tabButtons.forEach(btn => {
      if (btn.getAttribute('data-tab') === initialType) {
        btn.click();
        tabFound = true;
      }
    });
    if (!tabFound && tabButtons.length > 0) tabButtons[0].click();
  } else if (tabButtons.length > 0) {
    tabButtons[0].click();
  } else {
    updateNavButtons();
    updateFormControlsState();
  }

  updateMainPreview();
});
