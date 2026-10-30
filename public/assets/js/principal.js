document.addEventListener('DOMContentLoaded', () => {  
  const botonMenu = document.querySelector('[data-boton-menu]');  
  const navegacion = document.querySelector('[data-navegacion]');  
  if (botonMenu && navegacion) {    
    botonMenu.addEventListener('click', () => {      
      const abierto = navegacion.classList.toggle('esta-abierta');      
      botonMenu.setAttribute('aria-expanded', String(abierto));    
    });  
  }  

  document.querySelectorAll('[data-desplegable]').forEach((raiz) => {    
    const boton = raiz.querySelector('[data-desplegable-boton]');    
    const panel = raiz.querySelector('[data-desplegable-panel]');    
    if (!boton || !panel) return;    
    const cerrar = () => { panel.hidden = true; boton.setAttribute('aria-expanded', 'false'); };    
    boton.addEventListener('click', (evento) => {      
      evento.stopPropagation();      
      const abrir = panel.hidden;      
      document.querySelectorAll('[data-desplegable-panel]').forEach((p) => { p.hidden = true; });      
      panel.hidden = !abrir;      
      boton.setAttribute('aria-expanded', String(abrir));    
    });    
    document.addEventListener('click', (evento) => { if (!raiz.contains(evento.target)) cerrar(); });
    document.addEventListener('keydown', (evento) => { if (evento.key === 'Escape') cerrar(); });  
  });  

  document.querySelectorAll('.alerta').forEach((alerta) => {    
    alerta.querySelector('.alerta__cerrar')?.addEventListener('click', () => alerta.remove());    
    if (alerta.classList.contains('alerta--exito')) {      
      setTimeout(() => alerta.remove(), 6000);    }  
  });  

  document.querySelectorAll('[data-carrusel]').forEach((contenedor) => {    
    const pista = contenedor.querySelector('[data-carrusel-pista]');    
    contenedor.querySelectorAll('[data-carrusel-direccion]').forEach((boton) => {      
      boton.addEventListener('click', () => {        
        pista.scrollBy({ left: Number(boton.dataset.carruselDireccion) * pista.clientWidth * 0.8, behavior: 'smooth' });      });    });  
  });
});