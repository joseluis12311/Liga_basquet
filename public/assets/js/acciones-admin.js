document.addEventListener('DOMContentLoaded', () => {  
  document.querySelectorAll('form[data-confirmar]').forEach((formulario) => {    
    formulario.addEventListener('submit', (evento) => {      
      if (!window.confirm(formulario.dataset.confirmar)) evento.preventDefault();    });  });  

  document.querySelectorAll('[data-autoenviar]').forEach((seleccion) => {    
    seleccion.addEventListener('change', () => seleccion.form.submit());  });  

  document.querySelectorAll('input[type="file"][data-vista-previa]').forEach((entrada) => {    
    entrada.addEventListener('change', () => {      
      const destino = document.querySelector(entrada.dataset.vistaPrevia);      
      const archivo = entrada.files && entrada.files[0];      
      if (!destino || !archivo) return;      
      destino.src = URL.createObjectURL(archivo);      
      destino.hidden = false;
    });  });  

  const selectorEstado = document.querySelector('[data-selector-estado]');  
  const puntajes = document.querySelector('[data-puntajes]');  
  if (selectorEstado && puntajes) {    
    const alternar = () => {      
      const necesarios = selectorEstado.value === 'en_vivo' || selectorEstado.value === 'finalizado';      
      puntajes.querySelectorAll('input').forEach((entrada) => { entrada.disabled = !necesarios; });      
      puntajes.style.opacity = necesarios ? '1' : '.5';    };    
    selectorEstado.addEventListener('change', alternar);    
    alternar();  
  }
});