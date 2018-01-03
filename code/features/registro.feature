# features/registro.feature
#language es
Característica: register
Para poder loguearme y usar la aplicación antes necesito registrame
Para registrarme se realizará a través de Token usando Facebook y obteniendo de ahí el email

Escenario: El usuario pulsa en el botón de login a través de Facebook
Dado que tengo acceso a internet
Cuando ejecuto "register"
Entonces debería obtener:
