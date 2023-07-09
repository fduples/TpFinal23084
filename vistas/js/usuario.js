
//Método usado en modal de confirmación
function confirmaEliminar(userId) {
    if (confirm("Está a punto de eliminar este usuario")) {
        window.location.href = "../controladores/pacienteControl.php?borrar_id=" + userId;
    }
}

//Metodo usado en el modal de edición
function edicion(id, nombre, documento, correo, telefono, permiso) {
    document.getElementById("idEdita").value = id;
    document.getElementById("nombre").value = nombre;
    document.getElementById("documento").value = documento;
    document.getElementById("usuario").value = correo;
    document.getElementById("telefono").value = telefono;
    
    if (permiso == 'administrador') {
        document.getElementById("checkAdminEdita").checked = true;
        document.getElementById("permisoEdita").value = permiso;
    } else {
        document.getElementById("checkAdminEdita").checkbox = false;
        document.getElementById("permisoEdita").value = "noAdmin";
    }
}

function validarUsu() {
    console.log("ingreso validarUsu")

    let user=document.getElementById("usuario")

    if (!user.value.includes("@")) {
        // console.log("El usuario debe contener un @")
        document.getElementById("mensajeUsu").innerHTML="El usuario debe contener un @"
        document.getElementById("mensajeUsu").className="text-danger fw-bold p-2 rounded"
        user.className="form-control border border-danger border-3 fw-bold p-2 rounded"
        return false
    } else if(!user.value.toLowerCase().includes(".")) {
        document.getElementById("mensajeUsu").innerHTML="El correo no está completo"
        document.getElementById("mensajeUsu").className="text-danger fw-bold p-2 rounded"
        user.className="form-control border border-danger border-3 fw-bold p-2 rounded"
        return false
    } else {
        document.getElementById("mensajeUsu").innerHTML=""
        document.getElementById("mensajeUsu").className=""
        user.className="form-control border border-success border-3 fw-bold p-2 rounded"
        return true
    }
  
}

// determina la fortaleza de una pass
// si teiene menos de 4 caracteres es baja, entre 4 y 8 media, y más de 8 es alta
function defFortaleza() {
    
    let pass=document.getElementById("clave")

    const regex= new RegExp("(?=.*[a-z])(?=.*[A-Z]).{8,}")

    if (!regex.test(pass.value)) {
        document.getElementById("mensajePass").innerHTML="Password debe contener una  minúscula, una mayuscula y debe ser mayor a 8 caracteres"        
        document.getElementById("mensajePass").className="bg-danger p-1 m-1 rounded"
        pass.className="form-control border border-danger border-3 fw-bold p-2 rounded"
        return false
    } else {
        document.getElementById("mensajePass").innerHTML=""
        document.getElementById("mensajePass").className=""        
        pass.className="form-control border border-success border-3 fw-bold p-2 rounded"
        return true
    }
    
}

// verifica que la pass y la rep pass sean iguales
function compararPass() {
    let repPass=document.getElementById("repPass")
    let pass=document.getElementById("clave")

    if (repPass.value!=pass.value) {
        document.getElementById("mensajeCompara").innerHTML="La contraseñas no coinciden"        
        document.getElementById("mensajeCompara").className="bg-danger p-1 m-1 rounded"
        repPass.className="form-control border border-danger border-3 fw-bold p-2 rounded"
        return false
    } else {
        document.getElementById("mensajeCompara").innerHTML=""        
        document.getElementById("mensajeCompara").className=""
        repPass.className="form-control border border-success border-3 fw-bold p-2 rounded"
        return true
    }
}

// Habilitamos el boton cuando estan cumplidas las 3 condiciones

function validarTodo() {
    if (validarUsu() && defFortaleza() && compararPass()) {
        document.getElementById("enviar").className = "btn btn-primary"
    }
    
}

function mostrarCajaAdmin() {
    var checkbox = document.getElementById("checkAdmin");
    var cajaAdmin = document.getElementById("cajaAdmin");
    
    if (checkbox.checked) {
      cajaAdmin.style.display = "block";
    } else {
      cajaAdmin.style.display = "none";
    }
  }

  const claveAdminCorrecta = "23084";  // Clave de administración correcta

function comprobarClaveAdmin() {
    const claveIngresada = document.getElementById("claveAdmin").value;  // Obtener el valor ingresado en el campo de contraseña
    let mensaje = document.getElementById("mensajeAdmin");
    if (claveIngresada === claveAdminCorrecta) {
        // La clave es correcta envio mensaje y agrego el value de administrador al usuario
        mensaje.innerText = "Token correcto!";
        mensaje.style.color = "green";
        document.getElementById("permiso").value = "administrador";
        // Realizar las acciones que correspondan para un administrador válido
    } else {
        // La clave es incorrecta se lo informo al usuario
        mensaje.innerText = "Token incorrecto";
        mensaje.style.color = "red";
        document.getElementById("permiso").value = "noAdmin";
    }
}

document.getElementById("claveAdmin").onkeyup = comprobarClaveAdmin;
document.getElementById("usuario").onkeyup = validarTodo;
document.getElementById("clave").onkeyup = validarTodo;
document.getElementById("repPass").onkeyup = validarTodo;

