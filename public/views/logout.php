<?php
  SessionController::userLogout();
// Redirigir a la página de administración después de procesar el formulario
header("Location: /");
exit;