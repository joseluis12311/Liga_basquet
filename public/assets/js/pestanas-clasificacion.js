(() => {  
  document.querySelectorAll('[data-grupos]').forEach((contenedor) => {    
    const botones = contenedor.querySelectorAll('[data-grupo-boton]');    
    const tablas = contenedor.querySelectorAll('[data-grupo-tabla]');    
    botones.forEach((boton) => {
      boton.addEventListener('click', () => {        
        botones.forEach((b) => b.classList.toggle('es-activo', b === boton));        
        tablas.forEach((tabla) => { tabla.hidden = tabla.dataset.grupoTabla !== boton.dataset.grupoBoton; });      });    });  });
})();