import TomSelect from 'tom-select';


window.addEventListener('modalOpenedContratos', (event) => {
  const comitenteId = event.detail.comitenteId;

  const selectElement = document.querySelector("#select-tom");

  if (selectElement) {
    new TomSelect("#select-tom", {
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
  }

  const selectTomContrato = document.querySelector("#select-tom-contratos");
  if (selectTomContrato) {
    new TomSelect("#select-tom-contratos", {
      sortField: {
        field: "text",
        direction: "asc"
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
    new TomSelect("#select-tom-garantias", {
      sortField: {
        field: "text",
        direction: "asc"
      },

      onInitialize: function () {
        if (adquirenteId) this.setValue(adquirenteId);
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
      }

    });
  }

});