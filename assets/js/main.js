// Funciones principales del sistema de café

// Función para cargar reportes
function cargarReporte() {
  const loading = document.getElementById("loading")
  const cuerpoTabla = document.getElementById("cuerpoTabla")
  const pieTabla = document.getElementById("pieTabla")

  // Mostrar loading
  loading.style.display = "block"
  cuerpoTabla.innerHTML = ""
  pieTabla.style.display = "none"

  // Obtener valores del formulario
  const trabajadorId = document.getElementById("trabajador_filtro").value
  const fechaInicio = document.getElementById("fecha_inicio").value
  const fechaFin = document.getElementById("fecha_fin").value

  // Construir URL
  let url = "index.php?accion=obtener_reporte"
  const params = new URLSearchParams()

  if (trabajadorId) params.append("trabajador_id", trabajadorId)
  if (fechaInicio) params.append("fecha_inicio", fechaInicio)
  if (fechaFin) params.append("fecha_fin", fechaFin)

  if (params.toString()) {
    url += "&" + params.toString()
  }

  // Realizar petición
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      loading.style.display = "none"
      mostrarResultados(data)
    })
    .catch((error) => {
      loading.style.display = "none"
      console.error("Error:", error)
      alert("Error al cargar los datos")
    })
}

// Función para mostrar resultados en la tabla
function mostrarResultados(datos) {
  const cuerpoTabla = document.getElementById("cuerpoTabla")
  const pieTabla = document.getElementById("pieTabla")
  const totalKilos = document.getElementById("totalKilos")
  const totalValor = document.getElementById("totalValor")

  let html = ""
  let sumaKilos = 0
  let sumaValor = 0

  if (datos.length === 0) {
    html = '<tr><td colspan="5" class="text-center">No se encontraron registros</td></tr>'
  } else {
    datos.forEach((registro) => {
      const fecha = new Date(registro.fecha).toLocaleDateString("es-ES")
      const kilos = Number.parseFloat(registro.kilos)
      const valor = Number.parseFloat(registro.valor_pagado)

      sumaKilos += kilos
      sumaValor += valor

      html += `
                <tr>
                    <td>${fecha}</td>
                    <td>${registro.nombre_trabajador}</td>
                    <td><span class="badge bg-${obtenerColorCalidad(registro.calidad)}">${registro.calidad}</span></td>
                    <td>${kilos.toFixed(2)} kg</td>
                    <td>$${valor.toFixed(2)}</td>
                </tr>
            `
    })

    // Mostrar totales
    totalKilos.textContent = sumaKilos.toFixed(2) + " kg"
    totalValor.textContent = "$" + sumaValor.toFixed(2)
    pieTabla.style.display = "table-footer-group"
  }

  cuerpoTabla.innerHTML = html
}

// Función para obtener color según calidad
function obtenerColorCalidad(calidad) {
  switch (calidad) {
    case "bueno":
      return "success"
    case "regular":
      return "warning"
    case "malo":
      return "danger"
    default:
      return "secondary"
  }
}

// Función para limpiar filtros
function limpiarFiltros() {
  document.getElementById("formFiltros").reset()
  document.getElementById("cuerpoTabla").innerHTML = ""
  document.getElementById("pieTabla").style.display = "none"
}

// Validaciones para formularios
document.addEventListener("DOMContentLoaded", () => {
  // Validación del formulario de trabajador
  const formTrabajador = document.getElementById("formTrabajador")
  if (formTrabajador) {
    formTrabajador.addEventListener("submit", (e) => {
      if (!validarFormularioTrabajador()) {
        e.preventDefault()
      }
    })
  }

  // Validación del formulario de recolección
  const formRecoleccion = document.getElementById("formRecoleccion")
  if (formRecoleccion) {
    formRecoleccion.addEventListener("submit", (e) => {
      if (!validarFormularioRecoleccion()) {
        e.preventDefault()
      }
    })
  }

  // Cargar reporte inicial si estamos en la página de reportes
  if (document.getElementById("tablaReporte")) {
    cargarReporte()
  }
})

// Validación del formulario de trabajador
function validarFormularioTrabajador() {
  let valido = true

  const nombre = document.getElementById("nombre")
  const identificacion = document.getElementById("identificacion")

  // Limpiar validaciones anteriores
  limpiarValidaciones([nombre, identificacion])

  // Validar nombre
  if (!nombre.value.trim()) {
    mostrarError(nombre, "El nombre es obligatorio")
    valido = false
  } else if (nombre.value.trim().length < 3) {
    mostrarError(nombre, "El nombre debe tener al menos 3 caracteres")
    valido = false
  }

  // Validar identificación
  if (!identificacion.value.trim()) {
    mostrarError(identificacion, "La identificación es obligatoria")
    valido = false
  } else if (!/^\d+$/.test(identificacion.value.trim())) {
    mostrarError(identificacion, "La identificación debe contener solo números")
    valido = false
  }

  return valido
}

// Validación del formulario de recolección
function validarFormularioRecoleccion() {
  let valido = true

  const trabajadorId = document.getElementById("trabajador_id")
  const fecha = document.getElementById("fecha")
  const calidad = document.getElementById("calidad")
  const kilos = document.getElementById("kilos")

  // Limpiar validaciones anteriores
  limpiarValidaciones([trabajadorId, fecha, calidad, kilos])

  // Validar trabajador
  if (!trabajadorId.value) {
    mostrarError(trabajadorId, "Debe seleccionar un trabajador")
    valido = false
  }

  // Validar fecha
  if (!fecha.value) {
    mostrarError(fecha, "La fecha es obligatoria")
    valido = false
  } else {
    const fechaSeleccionada = new Date(fecha.value)
    const hoy = new Date()
    if (fechaSeleccionada > hoy) {
      mostrarError(fecha, "La fecha no puede ser futura")
      valido = false
    }
  }

  // Validar calidad
  if (!calidad.value) {
    mostrarError(calidad, "Debe seleccionar la calidad")
    valido = false
  }

  // Validar kilos
  if (!kilos.value) {
    mostrarError(kilos, "Los kilos son obligatorios")
    valido = false
  } else if (Number.parseFloat(kilos.value) <= 0) {
    mostrarError(kilos, "Los kilos deben ser mayor a 0")
    valido = false
  } else if (Number.parseFloat(kilos.value) > 1000) {
    mostrarError(kilos, "Los kilos no pueden ser mayor a 1000")
    valido = false
  }

  return valido
}

// Función para mostrar errores de validación
function mostrarError(elemento, mensaje) {
  elemento.classList.add("is-invalid")

  // Remover mensaje anterior si existe
  const mensajeAnterior = elemento.parentNode.querySelector(".invalid-feedback")
  if (mensajeAnterior) {
    mensajeAnterior.remove()
  }

  // Crear nuevo mensaje
  const divMensaje = document.createElement("div")
  divMensaje.className = "invalid-feedback"
  divMensaje.textContent = mensaje
  elemento.parentNode.appendChild(divMensaje)
}

// Función para limpiar validaciones
function limpiarValidaciones(elementos) {
  elementos.forEach((elemento) => {
    elemento.classList.remove("is-invalid", "is-valid")
    const mensaje = elemento.parentNode.querySelector(".invalid-feedback")
    if (mensaje) {
      mensaje.remove()
    }
  })
}

// Función para confirmar eliminaciones
function confirmarEliminacion(mensaje = "¿Está seguro de eliminar este registro?") {
  return confirm(mensaje)
}

// Función para formatear números
function formatearNumero(numero, decimales = 2) {
  return Number.parseFloat(numero).toFixed(decimales)
}

// Función para formatear moneda
function formatearMoneda(valor) {
  return "$" + formatearNumero(valor, 2)
}
