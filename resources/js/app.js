import TomSelect from 'tom-select';

import Swiper from 'swiper';
import 'swiper/css'; // Importa los estilos básicos de Swiper

// Opcional: Si necesitas módulos específicos, como navegación o paginación
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css/navigation';
import 'swiper/css/pagination';




function initSwiperAbiertasHome() {

  document.querySelectorAll('.swiper-home-subastas').forEach((el, index) => {

    if (el.swiper) {
      el.swiper.destroy(true, true);
    }


    const slides = el.querySelectorAll('.swiper-slide').length;
    // autoplay: { delay: 2000 },


    if (window.innerWidth >= 640) {
      console.log("INNNEEEEadd")
      new Swiper(el, {
        slidesPerView: 3,

        centerInsufficientSlides: true,
        spaceBetween: 50,
        loop: slides > 3 ? true : false,
        autoplay: slides > 3 ? { delay: 5000 } : false,


        // breakpoints: {
        //   420: {
        //     slidesPerView: 3,
        //   },
        // },
        modules: [Autoplay],

      });
    }
    else {
      console.log("MOBILE ")
      // En móvil quitamos clases de Swiper para que se vea como flex-col
      el.classList.remove("swiper-home-subastas");
      el.classList.remove("swiper-container");
      el.classList.add("flex", "flex-col");
    }
  });

}



function initSwiperDestacados() {
  document.querySelectorAll('.swiper-destacados').forEach((el) => {

    // destruir si existe
    if (el.swiper) {
      el.swiper.destroy(true, true);
    }

    const slides = el.querySelectorAll('.swiper-slide').length;

    // ⏳ esperar repaint real
    requestAnimationFrame(() => {
      new Swiper(el, {
        slidesPerView: 2,
        spaceBetween: 15,
        centerInsufficientSlides: true,
        loop: slides > 3,
        autoplay: slides > 3 ? { delay: 5000 } : false,

        breakpoints: {
          420: {
            slidesPerView: 3,
            spaceBetween: 50,
          },
        },

        modules: [Autoplay, Pagination],
        pagination: {
          el: el.querySelector('.swiper-pagination'),
          clickable: true,
        },
      });
    });
  });
}

document.addEventListener('livewire:navigated', () => {
  initSwiperDestacados();
  initSwiperAbiertasHome();
});

document.addEventListener('livewire:load', () => {
  initSwiperDestacados();
  initSwiperAbiertasHome();
});


// Configura tu Swiper
document.addEventListener('DOMContentLoaded', () => {


  const swiper = new Swiper('.swiper', {
    // Configuración básica
    slidesPerView: 1,

    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      // when window width is >= 320px
      420: {
        slidesPerView: 3,
        spaceBetween: 32
      },
    },

    // Opcional: Habilita módulos
    modules: [Navigation, Pagination, Autoplay],
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });



  document.querySelectorAll('.swiper-destacadosss').forEach((el, index) => {

    const slides = el.querySelectorAll('.swiper-slide').length;

    new Swiper(el, {
      slidesPerView: 2,
      spaceBetween: 15,
      centerInsufficientSlides: true,
      loop: true,
      autoplay: { delay: 5000 },
      breakpoints: {
        420: {
          slidesPerView: 3,
          spaceBetween: 50,
          loop: slides > 3 ? true : false,
          autoplay: slides > 3 ? { delay: 5000 } : false,
        },
      },
      modules: [Autoplay],

    });
  });

  document.querySelectorAll('.swiper-destacados-pujas').forEach((el, index) => {

    const slides = el.querySelectorAll('.swiper-slide').length;

    new Swiper(el, {
      slidesPerView: 3,
      spaceBetween: 15,
      centerInsufficientSlides: true,
      loop: true,
      autoplay: { delay: 5000 },
      breakpoints: {
        420: {
          slidesPerView: 5,
          spaceBetween: 50,
          loop: slides > 3 ? true : false,
          autoplay: slides > 3 ? { delay: 5000 } : false,
        },
      },
      modules: [Autoplay],

    });
  });



  document.querySelectorAll('.swiper-destacados-img').forEach((el, index) => {

    const slides = el.querySelectorAll('.swiper-slide').length;


    new Swiper(el, {
      slidesPerView: 3,
      spaceBetween: 15,
      centerInsufficientSlides: true,
      loop: slides > 3 ? true : false,
      autoplay: { delay: 5000 },
      breakpoints: {
        420: {
          slidesPerView: 4,
          spaceBetween: 50,
          loop: slides > 3 ? true : false,
          autoplay: slides > 3 ? { delay: 5000 } : false,
        },
      },
      modules: [Autoplay],

    });
  });


  // 
  // 

  const swiperPcElement = document.querySelector('.swiper-home-pc');
  if (swiperPcElement) {
    new Swiper(swiperPcElement, {
      slidesPerView: 7, // Muestra varias para llenar el ancho
      spaceBetween: 20,
      loop: true,
      centeredSlides: true, // Ayuda a que se vea estético detrás
      speed: 3000, // Movimiento suave y lento

      autoplay: {
        delay: 0, // Flujo continuo si usas linear easing
        disableOnInteraction: false,
      },
      modules: [Autoplay],
      // Opcional: para movimiento continuo lineal tipo cinta transportadora
      /*
      freeMode: true,
      freeModeMomentum: false,
      */
    });
  }

  const swiperPcElement2 = document.querySelector('.swiper-home-pc-2');
  if (swiperPcElement2) {
    new Swiper(swiperPcElement2, {
      slidesPerView: 7, // Muestra varias para llenar el ancho
      spaceBetween: 40,
      loop: true,
      centeredSlides: true, // Ayuda a que se vea estético detrás
      speed: 3000, // Movimiento suave y lento

      autoplay: {
        delay: 0, // Flujo continuo si usas linear easing
        disableOnInteraction: false,
      },
      modules: [Autoplay],
      // Opcional: para movimiento continuo lineal tipo cinta transportadora
      /*
      freeMode: true,
      freeModeMomentum: false,
      */
    });
  }


  document.querySelectorAll('.swiper-home-mb').forEach((el, index) => {

    const slides = el.querySelectorAll('.swiper-slide').length;

    console.log("INNNEEEEadd")
    new Swiper(el, {
      slidesPerView: 3,

      centerInsufficientSlides: true,
      spaceBetween: 50,
      loop: slides > 3 ? true : false,
      speed: 3000, // Movimiento suave y lento

      // autoplay: slides > 3 ? { delay: 2000 } : false,


      autoplay: {
        delay: 0, // Flujo continuo si usas linear easing
        disableOnInteraction: false,
      },

      // breakpoints: {
      //   420: {
      //     slidesPerView: 3,
      //   },
      // },
      modules: [Autoplay],

    });


  });

  // 
  // 


  document.querySelectorAll('.swiper-home-subastassss').forEach((el, index) => {

    const slides = el.querySelectorAll('.swiper-slide').length;
    // autoplay: { delay: 2000 },


    if (window.innerWidth >= 640) {
      console.log("INNNEEEEadd")
      new Swiper(el, {
        slidesPerView: 3,

        centerInsufficientSlides: true,
        spaceBetween: 50,
        loop: slides > 3 ? true : false,
        autoplay: slides > 3 ? { delay: 5000 } : false,


        // breakpoints: {
        //   420: {
        //     slidesPerView: 3,
        //   },
        // },
        modules: [Autoplay],

      });
    }
    else {
      console.log("MOBILE ")
      // En móvil quitamos clases de Swiper para que se vea como flex-col
      el.classList.remove("swiper-home-subastas");
      el.classList.remove("swiper-container");
      el.classList.add("flex", "flex-col");
    }
  });


  document.querySelectorAll('.swiper-subastas').forEach((el, index) => {

    const slides = el.querySelectorAll('.swiper-slide').length;

    new Swiper(el, {
      slidesPerView: 1,
      spaceBetween: 30,
      centerInsufficientSlides: true,
      loop: true,
      autoplay: { delay: 5000 },
      breakpoints: {
        420: {
          loop: slides > 3 ? true : false,
          slidesPerView: 3, spaceBetween: 32
        },
      },
      modules: [Autoplay],
    });
  });


});

// 8888888888888


window.addEventListener('modalOpenedContratos', (event) => {
  const comitenteId = event.detail.comitenteId;
  const selectTomContrato = document.querySelector("#select-tom-contratos");
  if (selectTomContrato) {
    new TomSelect("#select-tom-contratos", {
      sortField: {
        field: "text",
        direction: "asc"
      },
      onChange: function (value) {
        Livewire.dispatch('setComitente', { id: value });
      },

      onInitialize: function () {
        if (comitenteId) this.setValue(comitenteId);
      }
    });
  }

});


window.addEventListener('modalOpenedGarantias', (event) => {
  const adquirenteId = event.detail.adquirenteId;
  const selectTomGarantias = document.querySelector("#select-tom-garantias");

  if (selectTomGarantias) {
    if (selectTomGarantias.tomselect) {
      selectTomGarantias.tomselect.destroy();
    }

    new TomSelect("#select-tom-garantias", {
      sortField: {
        field: "text",
        direction: "asc"
      },
      // Escuchamos el evento 'change' de Tom Select
      onChange: function (value) {
        Livewire.dispatch('setAdquirente', { id: value });
      },
      onInitialize: function () {
        // Al inicializar, si recibimos un ID, lo establecemos como valor inicial
        if (adquirenteId) {
          this.setValue(adquirenteId);
        }
      }
    });
  }
});







window.addEventListener('modalOpenedTipoBien', (event) => {
  const encargadoId = event.detail.encargadoId;
  const selectTomEncargado = document.querySelector("#select-tom-tipo-bien-encargado");
  if (selectTomEncargado) {
    new TomSelect("#select-tom-tipo-bien-encargado", {
      sortField: {
        field: "text",
        direction: "asc"
      },
      onChange: function (value) {
        Livewire.dispatch('setEncargado', { id: value });
      },
      onInitialize: function () {
        if (encargadoId) this.setValue(encargadoId);
      }
    });
  }


  const suplenteId = event.detail.suplenteId;
  const selectTomSuplente = document.querySelector("#select-tom-tipo-bien-suplente");
  if (selectTomSuplente) {
    new TomSelect("#select-tom-tipo-bien-suplente", {
      sortField: {
        field: "text",
        direction: "asc"
      },
      onChange: function (value) {
        Livewire.dispatch('setSuplente', { id: value });
      },
      onInitialize: function () {
        if (suplenteId) this.setValue(suplenteId);
      }
    });
  }
});


window.addEventListener('modalOpenedTipoBienCampo', () => {
  const selectTomTPCampo = document.querySelector("#select-tom-tipo-bien-campo");
  if (selectTomTPCampo) {
    new TomSelect("#select-tom-tipo-bien-campo", {
      sortField: {
        field: "text",
        direction: "asc"
      },
      onChange: function (value) {
        Livewire.dispatch('setCampo', { id: value });
      },

    });
  }

});

window.addEventListener('reset-tom-select-campo', event => {
  const selectEl = document.querySelector("#select-tom-tipo-bien-campo");

  // Verificamos que el select y su instancia de TomSelect existan
  if (selectEl && selectEl.tomselect) {
    // Usamos el método `clear()` de la API de Tom Select para borrar la selección.
    selectEl.tomselect.clear();
  }
});
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
