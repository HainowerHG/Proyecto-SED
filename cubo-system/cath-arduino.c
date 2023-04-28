#include <Keypad.h>
#include <LiquidCrystal.h>

// Configuración LCD
LiquidCrystal lcd(13,12,11,10,9,8);

// Configuración teclado matricial 4x4
const byte ROWS = 4;
const byte COLS = 4;
char keys[ROWS][COLS] = {
  {'1', '2', '3', 'A'},
  {'4', '5', '6', 'B'},
  {'7', '8', '9', 'C'},
  {'*', '0', '#', 'D'}
};
byte rowPins[rows] = {7,6,5,4};
byte colPins[cols] = {3,2,1,0};
Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);



void setup() {
  Serial.begin(9600);
}

void loop() {
  // Esperar a recibir señal de inicio desde la Raspberry Pi
  while (!Serial.available()) {}

  // Inicializar el display LCD
  lcd.begin(16, 2);
  lcd.print("Ingrese clave:");

  char key;
  String clave = "0";
  int num_digitos = 0;

  while (true) {
    key = keypad.getKey();

    if (key != NO_KEY) {
      if (key == '#') {
        if (num_digitos == 4) {
          // Enviar clave a la Raspberry Pi
          Serial.println(clave);
        }
        clave = "";
        num_digitos = 0;
        lcd.clear();
        lcd.print("Ingrese clave:");
      } else if (num_digitos < 4) {
        clave += key;
        num_digitos++;
        lcd.setCursor(num_digitos - 1, 1);
        lcd.print("*");
      }
    }
  }
}
