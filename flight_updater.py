import mysql.connector
from amadeus import Client, ResponseError
import schedule
import time

# --- Amadeus API setup ---
amadeus = Client(
    client_id='Your Amadeus client_id',
    client_secret='Your Amadeus client_secret' 
)

# --- Cities to check flights between ---
city_pairs = [
    ('BOM', 'DEL'),
    ('DEL', 'BLR'), 
    ('MAA', 'CCU'), 
    ('HYD', 'PNQ'), 
    ('CCU', 'BOM'),
    ('BLR', 'MAA'), 
    ('AMD', 'JAI'), 
    ('PNQ', 'HYD'), 
    ('JAI', 'AMD'), 
    ('LKO', 'PAT') 
]

# --- MySQL DB setup ---
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="root",  
        database="airline"
    )

# --- Update flight data ---
def update_flights():
    print("🔄 Updating flight data...")
    try:
        conn = get_db_connection()
        cursor = conn.cursor()

        cursor.execute("DELETE FROM flights")
        conn.commit()

        flight_id = 1

        for (origin, destination) in city_pairs:
            try:
                response = amadeus.shopping.flight_offers_search.get(
                    originLocationCode=origin,
                    destinationLocationCode=destination,
                    departureDate='2025-04-15',
                    adults=1,
                    currencyCode='INR'
                )

                offer = response.data[0]
                price = float(offer['price']['total'])
                flight_number = offer['itineraries'][0]['segments'][0]['carrierCode'] + offer['itineraries'][0]['segments'][0]['number']

                # Insert into DB with original city names
                city_map = {
                    'BOM': 'Mumbai', 'DEL': 'Delhi', 'BLR': 'Bangalore',
                    'MAA': 'Chennai', 'CCU': 'Kolkata', 'HYD': 'Hyderabad',
                    'PNQ': 'Pune', 'AMD': 'Ahmedabad', 'JAI': 'Jaipur',
                    'LKO': 'Lucknow', 'PAT': 'Patna'
                }

                cursor.execute("""
                    INSERT INTO flights (id, departure_city, destination_city, price, flight_number)
                    VALUES (%s, %s, %s, %s, %s)
                """, (
                    flight_id,
                    city_map[origin],
                    city_map[destination],
                    price,
                    flight_number
                ))

                conn.commit()
                flight_id += 1

            except ResponseError as e:
                print(f"⚠️ Error fetching flight {origin} -> {destination}: {e}")

        print("✅ Flights updated successfully!")

    except Exception as e:
        print(f"❌ Database error: {e}")
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

schedule.every(10).minutes.do(update_flights)

# --- Initial run ---
update_flights()

# --- Keep running ---
while True:
    schedule.run_pending()
    time.sleep(1)
