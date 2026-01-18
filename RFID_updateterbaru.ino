#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <ArduinoJson.h>

/**
 * JANGAN GANTI DISINI, GANTI DI ARDUINO EDITOR
 */

#define SS_PIN D4
#define RST_PIN D3
#define BUZZER_PIN D0 // Pin untuk buzzer (GPIO 16)

#define WIFI_SSID "Hendri"
#define WIFI_PASSWORD "12121212"
#define SERVER_URL "http://sdit-baituljannah.my.id/sekolah" // Subdirektori aplikasi

const char* server_tap_url = SERVER_URL "/api/tap";
const char* server_scan_url = SERVER_URL "/api/store-scan";

MFRC522 rfid(SS_PIN, RST_PIN);
LiquidCrystal_I2C lcd(0x27, 16, 2);

void setup() {
  Serial.begin(115200);
  SPI.begin();
  rfid.PCD_Init();
  lcd.init();
  lcd.backlight();

  pinMode(BUZZER_PIN, OUTPUT); // Set pin buzzer sebagai output
  digitalWrite(BUZZER_PIN, LOW); // Matikan buzzer saat startup

  lcd.setCursor(0, 0);
  lcd.print("Menghubungkan WiFi");
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    lcd.print(".");
  }
  lcd.clear();
  lcd.print("WiFi Terhubung!");
  delay(1000);
}

void loop() {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Tempelkan Kartu");

  if (!rfid.PICC_IsNewCardPresent() || !rfid.PICC_ReadCardSerial()) {
    delay(100);
    return;
  }

  // Aktifkan buzzer saat kartu terdeteksi
  digitalWrite(BUZZER_PIN, HIGH);
  delay(200); // Bunyi selama 200 ms
  digitalWrite(BUZZER_PIN, LOW);

  String uid = "";
  for (byte i = 0; i < rfid.uid.size; i++) {
    uid += String(rfid.uid.uidByte[i] < 0x10 ? "0" : "");
    uid += String(rfid.uid.uidByte[i], HEX);
  }
  uid.toUpperCase();

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("UID: " + uid);

  if (WiFi.status() == WL_CONNECTED) {
    // Kirim UID ke endpoint untuk registrasi form
    httpPost(server_scan_url, "uid=" + uid);

    // Kirim UID ke endpoint untuk proses presensi/kegiatan
    String response = httpPost(server_tap_url, "uid=" + uid);
    
    // Tampilkan pesan dari server presensi
    lcd.setCursor(0, 1);
    if (response.length() == 0) {
      lcd.print("Respons Kosong");
      Serial.println("Tidak ada data respons diterima");
    } else if (response.indexOf("Siswa Tdk Ditemukan") != -1) {
      lcd.print("Belum Terdaftar");
    } else {
      // Parse JSON menggunakan ArduinoJson
      DynamicJsonDocument doc(200);
      DeserializationError error = deserializeJson(doc, response);
      if (!error) {
        String status = doc["status"];
        String message = doc["message"];
        if (status == "success") {
          if (message.length() > 16) {
            message = message.substring(0, 16);
          }
          lcd.print(message);
        } else if (status == "error") {
          lcd.print(message.length() > 16 ? message.substring(0, 16) : message);
        } else {
          lcd.print("Error Status");
          Serial.println("Status tidak dikenali: " + status);
        }
      } else {
        lcd.print("Error Parsing");
        Serial.println("Gagal parsing JSON: " + String(error.c_str()));
        Serial.println("Respons: " + response);
      }
    }

  } else {
    lcd.setCursor(0, 1);
    lcd.print("WiFi Terputus");
  }

  rfid.PICC_HaltA();
  delay(1000); // Kurangi dari 3000 untuk siklus lebih cepat
}

// Fungsi helper untuk melakukan HTTP POST
String httpPost(const char* url, String postData) {
  HTTPClient http;
  WiFiClient client;
  http.setTimeout(5000); // Kurangi dari 15000 menjadi 5000 ms
  http.begin(client, url);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  http.addHeader("Connection", "close");

  int httpCode = http.POST(postData);
  String payload = "";

  if (httpCode > 0) {
    WiFiClient *stream = http.getStreamPtr();
    unsigned long timeout = millis();
    while (http.connected() && (millis() - timeout < 3000)) { // Kurangi dari 10000 menjadi 3000 ms
      if (stream->available()) {
        char c = stream->read();
        payload += c;
        timeout = millis();
      }
      yield();
    }
    Serial.println("URL: " + String(url));
    Serial.println("Kode HTTP: " + String(httpCode));
    Serial.println("Respons: " + payload);
    Serial.println("Panjang Respons: " + String(payload.length()));
  } else {
    Serial.println("URL: " + String(url));
    Serial.println("Error HTTP: " + http.errorToString(httpCode));
  }

  http.end();
  return payload;
}