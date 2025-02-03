# Configuración de Entorno Virtual en Python

## Pasos para Configurar el Entorno Virtual e Instalar Selenium

### 1. Descargar el paquete necesario:
Ejecuta el siguiente comando para instalar el paquete necesario para crear entornos virtuales en Python:

```bash
sudo apt install python3-venv -y
```

### 2. Crear el entorno virtual:
Crea el entorno virtual en la carpeta que prefieras. En este caso, se llamará `wselenium`:

```bash
python3 -m venv wselenium
cd wselenium
```

### 3. Instalar Selenium:
Dentro del entorno virtual, instala la librería **Selenium**:

```bash
pip install -U selenium
```

### 4. Activar el entorno virtual:
Para activar el entorno virtual, ejecuta:

```bash
source bin/activate
```

### 5. Crear el archivo con comandos de Selenium:
Usa un editor de texto como `nano` para crear un archivo Python donde escribirás los comandos de Selenium:

```bash
nano archivo.py
```

### 6. Ejecutar el archivo de Selenium:
Finalmente, ejecuta el archivo con los comandos de Selenium:

```bash
python3 archivo.py
```

## Notas:
- Recuerda que para desactivar el entorno virtual, puedes usar el comando `deactivate`.
- Asegúrate de que tienes instalada una versión de Python compatible con Selenium.
- Si necesitas más dependencias para tu proyecto, puedes instalarlas usando `pip install`.

¡Y listo! Ahora tienes tu entorno configurado para trabajar con Selenium.
## Autores

- [@Fernandodg97](https://github.com/Fernandodg97)


## License

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/deed.es)

