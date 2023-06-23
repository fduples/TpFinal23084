
function validarUsu() {
    console.log("ingreso validarUsu")

    let user=document.getElementById("usuario")

    if (!user.value.includes("@")) {
        // console.log("El usuario debe contener un @")
        document.getElementById("mensajeUsu").innerHTML="El usuario debe contener un @"
        document.getElementById("mensajeUsu").className="text-danger fw-bold p-2 rounded"
        return false
    } else if(!user.value.toLowerCase().includes(".")) {
        document.getElementById("mensajeUsu").innerHTML="El correo no está completo"
        document.getElementById("mensajeUsu").className="text-danger fw-bold p-2 rounded"
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

document.getElementById("user").onkeyup = validarTodo;
document.getElementById("pass").onkeyup = validarTodo;
document.getElementById("repPass").onkeyup = validarTodo;
