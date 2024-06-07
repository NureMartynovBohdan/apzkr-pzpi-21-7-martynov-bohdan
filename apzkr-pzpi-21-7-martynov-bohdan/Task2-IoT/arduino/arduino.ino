#include <MFRC522.h>
#include <MFRC522Extended.h>
#include <deprecated.h>
#include <require_cpp11.h>
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10
#define RST_PIN 9
#define GREEN_LED 7
#define RED_LED 6
#define BUZZER 8

MFRC522 rfid(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(115200); 
  SPI.begin(); 
  rfid.PCD_Init(); 
  pinMode(GREEN_LED, OUTPUT); 
  pinMode(RED_LED, OUTPUT);
  pinMode(BUZZER, OUTPUT); 
}

void loop() {
    if (!rfid.PICC_IsNewCardPresent() || !rfid.PICC_ReadCardSerial()) {
    return; 
  }
  
  String uid = "";
  for (byte i = 0; i < rfid.uid.size; i++) {
    uid += String(rfid.uid.uidByte[i], HEX); 
  }

  Serial.print("RFID UID: ");
  Serial.println(uid);

  delay(1000);
  digitalWrite(GREEN_LED, LOW); 
  digitalWrite(RED_LED, LOW); 
}