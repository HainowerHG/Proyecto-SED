from cv2 import VideoCapture, cvtColor, COLOR_BGR2RGB
import threading
from face_recognition import load_image_file, face_encodings, face_locations, compare_faces
import RPi.GPIO as GPIO
from serial import Serial
import time
import json


# Establecer la conexión serial
ser = Serial('/dev/ttyACM0', 9600)

# Definir el tiempo que durará el reconocimiento facial en segundos
duracion_reconocimiento = 30

# Variable de estado para reconocimiento facial
reconocimiento_activo = False
facial= False
#variable de tiempo en ejecucion en el reconocimienot facial
tiempo_transcurrido = 0

# Configurar pin GPIO
GPIO.setmode(GPIO.BCM)
# Configurar el pin GPIO23 como entrada para el MOTION DETECTOR
GPIO.setup(18, GPIO.IN)
# Configurar el pin GPIO 18 - 24 - 25 como salida para el Led RGB
GPIO.setup(23, GPIO.OUT)
GPIO.setup(24, GPIO.OUT)
GPIO.setup(25, GPIO.OUT)

# Función para encender LED RGB en un color específico
def encender_led_rgb(rojo, verde, azul):
    GPIO.output(25, rojo)
    GPIO.output(24, verde)
    GPIO.output(23, azul)

# Cargar imagen de muestra y codificar rostro
imagen_muestra = load_image_file("haino.jpg")
codificacion_muestra = face_encodings(imagen_muestra)[0]

# Inicializar cámara
camara = VideoCapture(0)

encender_led_rgb(0,0,1)
time.sleep(2)
encender_led_rgb(0,0,0)

# comportamiento itermitente del led
def led_itermitente():
    while True:
        encender_led_rgb(255, 255, 0) # Encender el LED RGB con el color rojo
        time.sleep(0.5)
        encender_led_rgb(0, 0, 0)  # Apagar el LED RGB
        time.sleep(0.5)

# Manejador de interrupciones
def manejador_interrupcion(pin):
    global reconocimiento_activo
    # Si se detecta movimiento en el pin GPIO23, llamar a la función de reconocimiento facial
    if not reconocimiento_activo:
        reconocimiento_activo = True
        reconocimiento_facial()
    

# Configurar interrupción en el pin GPIO23
GPIO.add_event_detect(18, GPIO.RISING, callback=manejador_interrupcion)


# Función de reconocimiento facial
def reconocimiento_facial():
    
    # Definir el tiempo inicial
    global tiempo_transcurrido
    tiempo_inicial = time.time()
    # encender led`s amarillo alerta de inicio
    encender_led_rgb(255, 255, 0)

    # Loop de reconocimiento facial
    while time.time() - tiempo_inicial < duracion_reconocimiento:
        time.sleep(2)
        #Si ha transcurrido menos de 10 segundos, encender el LED del pin 18 y esperar
        if tiempo_transcurrido < duracion_reconocimiento / 2:
            time.sleep(0.1)
            # Capturar un fotograma de la cámara
            ret, fotograma = camara.read()
            
            # Convertir imagen de OpenCV (BGR) a RGB para face_recognition
            fotograma_rgb = cvtColor(fotograma, COLOR_BGR2RGB)

            # Detectar rostros en el fotograma
            ubicaciones_rostros = face_locations(fotograma_rgb)
            
            # Codificar los rostros detectados
            codificaciones_rostros = face_encodings(fotograma_rgb, ubicaciones_rostros)

            # Comparar los rostros detectados con la imagen de muestra
            global facial
            for codificacion_rostro, ubicacion_rostro in zip(codificaciones_rostros, ubicaciones_rostros):
                comparacion = compare_faces([codificacion_muestra], codificacion_rostro)
                
                if comparacion[0]:
                    # Si el rostro detectado coincide con la imagen de muestra
                    encender_led_rgb(0, 1, 0)
                    print("reconocimiento facial exitoso")
                    time.sleep(5)
                    facial = True
                    return

                else:
                    # Si el rostro no se reconoce
                    encender_led_rgb(1, 0, 0)
                    print("reconocimiento facial fallido")
                    time.sleep(5)
                    facial = True
                    return
                
            # Calcular el tiempo que ha transcurrido
            tiempo_transcurrido = time.time() - tiempo_inicial
            print(tiempo_transcurrido)
            print(facial)
        # Si ha transcurrido más de 10 segundos, intermitir el LED RGB con una frecuencia de frecuencia_intermitencia
        elif tiempo_transcurrido > duracion_reconocimiento / 2:
            encender_led_rgb(0, 0, 0)  # Apagar el LED RGB
            camara.release()
            t = threading.Thread(target=led_itermitente)
            t.start()
            # Enviar señal de inicio al Arduino
            mensaje_inicio = '1'  # Mensaje de inicio a enviar
            ser.write(mensaje_inicio.encode())  # Convertir mensaje a bytes y enviarlo
            while True:
                print("Recibido")
                
                clave = ser.readline().decode().rstrip()
                if clave:
                    t = threading.Thread(target=led_itermitente)
                    t.start()
                    # Leer el archivo JSON con los datos de los usuarios
                    with open('usuaios.json', 'r') as f:
                        usuarios = json.load(f)
                    for usuario in usuarios:
                        if usuario['password'] == clave:
                            encender_led_rgb(0, 1, 0)
                            print("reconocimiento facial exitoso")
                            time.sleep(2) 
                            facial = True
                            return
                    else:
                        print(f"No se encontró ningún usuario con el password {clave}")
                        encender_led_rgb(1, 0, 0)
                        time.sleep(2)
                        facial = True
                        return

# Loop principal

while True:
   
    # Esperar hasta que se presione la tecla 'q' para salir del bucle
    if reconocimiento_activo and (tiempo_transcurrido >= duracion_reconocimiento) or facial == True:
        break


# Liberar recursos
encender_led_rgb(0, 0, 0)  # Apagar el LED RGB
GPIO.cleanup()

