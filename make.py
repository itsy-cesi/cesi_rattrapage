import os
import psycopg2

# Clear console screen
os.system('cls' if os.name == 'nt' else 'clear')

# Connect to PostgreSQL database
try:
    conn = psycopg2.connect(
        host=os.getenv('DB_HOST', '127.0.0.1'),
        port=os.getenv('DB_PORT', 5432),
        user=os.getenv('DB_USERNAME', 'postgres'),
        password=os.getenv('DB_PASSWORD')
    )
    conn.set_isolation_level(psycopg2.extensions.ISOLATION_LEVEL_AUTOCOMMIT)
    cur = conn.cursor()

    # Check if database already exists
    cur.execute(f"SELECT 1 FROM pg_database WHERE datname = '{os.getenv('DB_DATABASE')}'")
    exists = cur.fetchone()

    if exists: # Database already exists
        print("Database already exists.")
    else: # Database do not exist
        cur.execute(f"CREATE DATABASE {os.getenv('DB_DATABASE')}")
        print("Database created.")

    cur.close()
    conn.close()

    # Successfully created
    print()
    print("Migration required. Please run: `php artisan migrate`")

except psycopg2.Error as e:
    # Errors handling
    print(f"Error connecting to database: {e}")
    print("Migration failed.")
