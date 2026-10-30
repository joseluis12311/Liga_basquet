(() => {  
  const raiz = document.querySelector('[data-filtro-partidos]');  
  if (!raiz) return;  
  const pestanas = raiz.querySelectorAll('[data-filtro-categoria]');  
  const grupos = raiz.querySelectorAll('[data-grupo]');
  const vacio = raiz.querySelector('[data-vacio]');  
  const interruptorEnVivo = raiz.querySelector('#interruptor-en-vivo');  
  const interruptorOcultar = raiz.querySelector('#interruptor-ocultar');  
  const estado = { categoria: 'todos', soloEnVivo: false };  

  function aplicar() {    
    let visiblesTotal = 0;    
    grupos.forEach((grupo) => {      
      let visibles = 0;      
      grupo.querySelectorAll('.partido').forEach((tarjeta) => {        
        const coincideCategoria = estado.categoria === 'todos' || tarjeta.dataset.categoria === estado.categoria;        
        const coincideVivo = !estado.soloEnVivo || tarjeta.dataset.estado === 'en_vivo';        
        tarjeta.hidden = !(coincideCategoria && coincideVivo);        
        if (!tarjeta.hidden) visibles += 1;      });      
      grupo.hidden = visibles === 0;      
      visiblesTotal += visibles;    });    
    if (vacio) vacio.hidden = visiblesTotal > 0;  
  }  

  pestanas.forEach((pestana) => {    
    pestana.addEventListener('click', () => {      
      estado.categoria = pestana.dataset.filtroCategoria;      
      pestanas.forEach((p) => {        
        const activa = p === pestana;        
        p.classList.toggle('es-activo', activa);        
        p.setAttribute('aria-selected', String(activa));      });      
      aplicar();
    });  });  

  interruptorEnVivo?.addEventListener('change', () => { estado.soloEnVivo = interruptorEnVivo.checked; aplicar(); });  

  const CLAVE = 'liga.ocultarPuntos';  
  const ocultar = (valor) => document.body.classList.toggle('ocultar-puntos', valor);  
  try {    
    const guardado = localStorage.getItem(CLAVE) === '1';    
    if (interruptorOcultar) interruptorOcultar.checked = guardado;    
    ocultar(guardado);  
  } catch (e) {}  

  interruptorOcultar?.addEventListener('change', () => {    
    ocultar(interruptorOcultar.checked);    
    try { localStorage.setItem(CLAVE, interruptorOcultar.checked ? '1' : '0'); } catch (e) {}  
  });  
  aplicar();
})();