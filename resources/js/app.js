import TomSelect from 'tom-select';


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
