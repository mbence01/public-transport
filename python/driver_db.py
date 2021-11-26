import requests as req
import mysql.connector as sql
import random
import shutil
import os

db = sql.connect(
    host = "localhost",
    user = "madranszki",
    password = "mB!2001!0906",
    database = "public-transport"
)

generator = 'https://www.random-name-generator.com/hungary?gender=&n='

cursor = db.cursor()

def generateRandomImage(female):
    if female:
        return 'https://www.random-name-generator.com/images/faces/female-white/' + str(random.randint(1, 50)) + '.jpg'
    
    return 'https://www.random-name-generator.com/images/faces/male-white/' + str(random.randint(1, 50)) + '.jpg'



n = int(input('How many drivers do you wanna add to the database? '))

generator += str(n)



r = req.get(generator)
prev_pos = 0
search = '<dd class="h4 col-12">'.encode('UTF-8')
search_str = search.decode('UTF-8')


for line in r.iter_lines():
    if search in line:
        image = generateRandomImage(b'(female)' in line) 

        l = line.decode('UTF-8').strip()
        l = l[len(search_str):l.find('<', 2) - 1:]
        name = l.split(' ')

        print('New driver:', l)
        print('Downloading profile picture for him/her...')

        getimg = req.get(image, stream = True)
        getimg.raw.decode_content = True
        fname = l.lower().replace(' ', '_') + '.jpg'


        unique_id = '1'
        unique_id += str(random.randint(50, 99))
        unique_id += '{:02d}'.format(random.randint(0, 12))
        unique_id += '{:02d}'.format(random.randint(0, 31))
        unique_id += str(random.randint(100, 999))


        randMonth = random.randint(1, 12)
        randDay = random.randint(1, 31)

        if randMonth in [ 4, 6, 9, 11 ]:
            randDay = random.randint(1, 30)
        else:
            if randMonth == 2:
                randDay = random.randint(1, 28)               



        join_date = '{0}-{1:02d}-{2:02d}'.format(random.randint(1990, 2020), randMonth, randDay)


        with open(fname, 'wb') as f:
            shutil.copyfileobj(getimg.raw, f)

        with open(fname, 'rb') as f:
            bin = f.read()

        os.remove(fname)


        insert_str = """INSERT INTO sofor VALUES(%s, %s, %s, %s, %s)"""
        insert_tuple = (name[1], name[0], unique_id, join_date, bin)


        cursor.execute(insert_str, insert_tuple)
        db.commit()


        print('Updated driver with unique ID:', unique_id + ', join date:', join_date + '\n')

