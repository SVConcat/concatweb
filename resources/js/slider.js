import KeenSlider from 'keen-slider'
import 'keen-slider/keen-slider.min.css'

//time the slider pauses at each step
const pauseTime = 2500;
//time the slide animation takes
const animationTime = 1500;

var slider = new KeenSlider(
  '#home-slider',
  {
    loop: true,
    slides:{
        spacing: 10,
        perView:0.98, //don't ask...
    },
    defaultAnimation: {
        duration: animationTime,
    },
  },
  [
    (slider) => {
            let timeout
            let mouseOver = false
            function clearNextTimeout() {
              clearTimeout(timeout)
            }
            function nextTimeout() {
              clearTimeout(timeout)
              if (mouseOver) return
              timeout = setTimeout(() => {
                slider.next()
              }, pauseTime)
            }
            slider.on("created", () => {
              slider.container.addEventListener("mouseover", () => {
                mouseOver = true
                clearNextTimeout()
              })
              slider.container.addEventListener("mouseout", () => {
                mouseOver = false
                nextTimeout()
              })
              nextTimeout()
            })
            slider.on("dragStarted", clearNextTimeout)
            slider.on("animationEnded", nextTimeout)
            slider.on("updated", nextTimeout)
          },
    
  ]
)