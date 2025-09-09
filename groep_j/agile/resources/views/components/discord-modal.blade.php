@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/discord-modal.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/discord-modal.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush

@php
    $discordChannels = config('discord.channels', []);
    $discordTags = config('discord.tags', []);
    $defaultColor = config('discord.default_embed_color', '#3498db');
    $botName = config('discord.bot_name', 'Discord Bot');
    $discordDefaults = [
        'enabled' => old('discord.enabled', '0'),
        'type' => old('discord.type', 'standard'),
        'channel' => old('discord.channel', ''),
        'tag' => old('discord.tag', ''),
        'title' => old('discord.title', ''),
        'description' => old('discord.description', ''),
        'embed_color' => old('discord.embed_color', $defaultColor)
    ];
@endphp

<div class="discord-section">
    <div data-discord-config>
        @foreach(['enabled','type','channel','tag','title','description','embed_color'] as $field)
            <input type="hidden" name="discord[{{ $field }}]" id="discord_{{ $field }}"
                   value="{{ $discordDefaults[$field] }}">
        @endforeach
    </div>

    <label for="discordToggle" class="discord-label">Discord Bericht</label>
    <div class="discord-controls">
        <div class="discord-checkbox-wrapper">
            <input type="checkbox" id="discordToggle" class="discord-checkbox"
                {{ $discordDefaults['enabled'] === '1' ? 'checked' : '' }}>
        </div>
        <button type="button" id="openModalBtn" class="discord-button"
            {{ $discordDefaults['enabled'] === '1' ? '' : 'disabled' }}>
            Discord Bericht Configureren
        </button>
    </div>
    <div id="discord-hint" class="discord-hint" style="{{ $discordDefaults['enabled'] === '1' ? 'display:none;' : '' }}">
        Vink het vakje aan om een Discord bericht te configureren
    </div>

    <div id="discord-preview" class="preview-content dark:bg-gray-700 mt-4"
         style="display: {{ $discordDefaults['enabled'] === '1' ? 'block' : 'none' }}">
        <h4 class="text-lg font-semibold mb-3 dark:text-white">Discord Bericht Voorbeeld:</h4>
        <div class="discord-message-card">
            <div class="message-header">
                <span class="bot-name dark:text-white">{{ $botName }}</span>
                <span class="message-timestamp dark:text-gray-400">vandaag om {{ now()->format('H:i') }}</span>
            </div>
            <div class="message-content">
                @php
                    $selectedTag = $discordDefaults['tag'];
                    $tagDisplay = $selectedTag && isset($discordTags[$selectedTag]) ? $discordTags[$selectedTag]['name'] : '';
                @endphp
                <div class="message-tag dark:text-blue-400" id="preview-tag" style="{{ $tagDisplay ? '' : 'display:none;' }}">
                    {{ $tagDisplay }}
                </div>

                <div id="preview-standard" style="display: {{ $discordDefaults['type'] === 'embed' ? 'none' : 'block' }}">
                    <div class="message-title dark:text-white" id="preview-title">{{ $discordDefaults['title'] }}</div>
                    <div class="message-description dark:text-gray-300" id="preview-description">{{ $discordDefaults['description'] }}</div>
                </div>

                <div id="preview-embed" style="display: {{ $discordDefaults['type'] === 'embed' ? 'block' : 'none' }}">
                    <div class="discord-embed">
                        <div class="embed-color-bar" style="background-color: {{ $discordDefaults['embed_color'] }}"></div>
                        <div class="embed-rich-content">
                            <div class="embed-title">{{ $discordDefaults['title'] }}</div>
                            <div class="embed-description">{{ $discordDefaults['description'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="message-footer dark:text-gray-400">
                @php
                    $selectedChannel = $discordDefaults['channel'];
                    $channelDisplay = $selectedChannel && isset($discordChannels[$selectedChannel])
                        ? $discordChannels[$selectedChannel]['name']
                        : '(Geen kanaal geselecteerd)';
                @endphp
                <small>Verzonden naar <span class="channel-name">#{{ $channelDisplay }}</span></small>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-content dark:bg-gray-800">
        <span class="close-button dark:text-gray-400">&times;</span>
        <h2 class="text-2xl font-bold mb-6 dark:text-white">Discord Bericht Configureren</h2>

        <div class="tabs">
            <button type="button" class="tab-button {{ $discordDefaults['type'] === 'standard' ? 'active' : '' }} dark:text-gray-300" data-tab="standard">Standaard</button>
            <button type="button" class="tab-button {{ $discordDefaults['type'] === 'embed' ? 'active' : '' }} dark:text-gray-300" data-tab="embed">Embed</button>
        </div>

        {{-- Standard Flow --}}
        <div id="standard-content" class="tab-content {{ $discordDefaults['type'] === 'standard' ? 'active' : '' }}">
            <div class="step-pages">
                <div class="step-page active" data-page="1">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Kanaal & Tag Selectie</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="discord_channel_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Kanaal:</label>
                            <select name="discord[channel]" id="discord_channel_modal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Kanaal --</option>
                                @foreach($discordChannels as $key => $channel)
                                    <option value="{{ $key }}" {{ $discordDefaults['channel'] === $key ? 'selected' : '' }}>
                                        #{{ $channel['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discord_tag_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Tag:</label>
                            <select name="discord[tag]" id="discord_tag_modal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Tag --</option>
                                @foreach($discordTags as $key => $tag)
                                    <option value="{{ $key }}" {{ $discordDefaults['tag'] === $key ? 'selected' : '' }}>
                                        {{ $tag['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="step-page" data-page="2">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Bericht Inhoud</h3>
                    <div class="form-group">
                        <label for="discord_title_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bericht Titel:</label>
                        <input type="text" name="discord[title]" id="discord_title_modal" value="{{ $discordDefaults['title'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Voer bericht titel in">
                    </div>
                    <div class="form-group">
                        <label for="discord_description_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bericht Inhoud:</label>
                        <textarea name="discord[description]" id="discord_description_modal" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Voer het bericht in">{{ $discordDefaults['description'] }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Embed Flow --}}
        <div id="embed-content" class="tab-content {{ $discordDefaults['type'] === 'embed' ? 'active' : '' }}">
            <div class="step-pages">
                <div class="step-page active" data-page="1">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Kanaal, Tag & Kleur</h3>
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label for="discord_channel_embed_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Kanaal:</label>
                            <select name="discord[channel]" id="discord_channel_embed_modal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Kanaal --</option>
                                @foreach($discordChannels as $key => $channel)
                                    <option value="{{ $key }}" {{ $discordDefaults['channel'] === $key ? 'selected' : '' }}>
                                        #{{ $channel['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discord_tag_embed_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Tag:</label>
                            <select name="discord[tag]" id="discord_tag_embed_modal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Tag --</option>
                                @foreach($discordTags as $key => $tag)
                                    <option value="{{ $key }}" {{ $discordDefaults['tag'] === $key ? 'selected' : '' }}>
                                        {{ $tag['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discord_embed_color_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Embed Kleur:</label>
                            <input type="color" name="discord[embed_color]" id="discord_embed_color_modal" value="{{ $discordDefaults['embed_color'] }}" class="bg-gray-50 border border-gray-300 rounded-lg w-16 h-10">
                        </div>
                    </div>
                </div>
                <div class="step-page" data-page="2">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Bericht Inhoud</h3>
                    <div class="form-group">
                        <label for="discord_title_embed_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Embed Titel:</label>
                        <input type="text" name="discord[title]" id="discord_title_embed_modal" value="{{ $discordDefaults['title'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Voer embed titel in">
                    </div>
                    <div class="form-group">
                        <label for="discord_description_embed_modal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Embed Tekst (met opmaak):</label>
                        <textarea name="discord[description]" id="discord_description_embed_modal" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Gebruik **vet**, *cursief*, __onderstreept__, ~~doorgestreept~~ voor opmaak.">{{ $discordDefaults['description'] }}</textarea>
                        <small class="text-gray-500 dark:text-gray-400">Markdown zoals **vet**, *cursief*, <code>code</code> wordt ondersteund.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button" class="button left step-btn-prev" style="display: none;">Vorige</button>
            <button type="button" class="button right step-btn-next">Volgende</button>
            <button type="button" class="button right step-btn-submit" style="display: none;">Configuratie Opslaan</button>
        </div>
    </div>
</div>
