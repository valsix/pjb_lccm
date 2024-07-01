import sys
import json
import psycopg2
from psycopg2 import Error

try:
    # Parameter koneksi ke database PostgreSQL
    connection = psycopg2.connect(
        user="postgres",  # Ganti dengan nama pengguna PostgreSQL Anda
        password="root",  # Ganti dengan password PostgreSQL Anda
        host="192.168.88.100",
        port="5432",
        database="lccm2"  # Ganti dengan nama database PostgreSQL Anda
    )


    # Membuat cursor untuk eksekusi perintah SQL
    cursor = connection.cursor()


    # Ambil argumen JSON dari PHP (dalam bentuk string)
    reqAssetNum = sys.argv[1]
    reqCapital = sys.argv[2]
    reqCapitalDate = sys.argv[3]
    reqTanggal = sys.argv[4]
    reqUser = sys.argv[5]
    reqDistrikId = sys.argv[6]
    reqBlokId = sys.argv[7]
    reqUnitMesinId = sys.argv[8]
    reqProjectNo = sys.argv[9]

    # Parse JSON menjadi array di Python
    reqAssetNum = json.loads(reqAssetNum)
    reqCapital = json.loads(reqCapital)
    reqCapitalDate = json.loads(reqCapitalDate)
    jumlah_data = len(reqAssetNum)
    i=0
    for yaaa in range(jumlah_data):
        if reqCapitalDate[i] == 'null':
            reqCapitalDateInsert='2000-01-01'
        else:
            reqCapitalDateInsert=reqCapitalDate[i]

        if reqCapital[i] == 'null':
            reqCapitalInsert='0'
        else:
            reqCapitalInsert=reqCapital[i]
      
        insert_query = """
            INSERT INTO t_lccm_asset_param ( 
                KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M, PROJECT_NAME, ASSETNUM, CAPITAL_DATE, CAPITAL,CAPITAL_LCCM,LAST_CREATE_USER, LAST_CREATE_DATE )
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
        """
        record_to_insert = ( reqDistrikId, reqBlokId, reqUnitMesinId, reqProjectNo, reqAssetNum[i] , reqCapitalDateInsert, reqCapitalInsert, reqCapitalInsert, reqUser,  reqTanggal)
        cursor.execute(insert_query, record_to_insert)
        connection.commit()
        i=i+1

    # Commit perubahan ke database
    print("Data berhasil dimasukkan ke dalam tabel")

except (Exception, Error) as error:
    print("Error saat terhubung ke PostgreSQL:", error)

finally:
    # Menutup koneksi dan cursor
    if connection:
        cursor.close()
        connection.close()
        print("Koneksi PostgreSQL ditutup")
