import requests as req
import mysql.connector as sql

db = sql.connect(
    host = "localhost",
    user = "madranszki",
    password = "mB!2001!0906",
    database = "public-transport"
)

cursor = db.cursor()

def convert(text):
    text = text.replace('\\u00e1', 'á')
    text = text.replace('\\u00c1', 'Á')
    text = text.replace('\\u00e9', 'é')
    text = text.replace('\\u00c9', 'É')
    text = text.replace('\\u00ed', 'í')
    text = text.replace('\\u00cd', 'Í')
    text = text.replace('\\u00f3', 'ó')
    text = text.replace('\\u00d3', 'Ó')
    text = text.replace('\\u00f6', 'ö')
    text = text.replace('\\u00d6', 'Ö')
    text = text.replace('\\u0151', 'ő')
    text = text.replace('\\u0150', 'Ő')
    text = text.replace('\\u00fa', 'ú')
    text = text.replace('\\u00da', 'Ú')
    text = text.replace('\\u00fc', 'ü')
    text = text.replace('\\u00dc', 'Ü')
    text = text.replace('\\u0171', 'ű')
    text = text.replace('\\u0170', 'Ű')

    return text


res = req.get('https://szkt.hu/menetrendek')
p = False
found = 0

routes = []
route_links = []
stops = []
full_list = {}

for line in res.iter_lines():
    if p:
        l = line.decode('UTF-8').strip()

        routes.append(l[:l.find(' '):])
        
        p = False

    if "https://szkt.hu/route/" in str(line):
        l = line.decode('UTF-8').strip()

        if found > 11:
            route_links.append(l[l.find('"') + 1:l.find('"', l.find('"') + 1):])
            p = True

        found += 1


prev_pos = 0

for i in range(len(route_links)):
    res = req.get(route_links[i])
    text = res.text

    print('Downloading', routes[i], 'route\'s stops...')

    full_list[i] = list()

    while True:
        start = text.find('"name":', prev_pos) + 8
        end = text.find('"', start + 1)

        if end == text.find('","sequence":"1"', start) and prev_pos != 0:
            break 

        if convert(text[start:end:]) in full_list[i]:
            full_list[i].append(convert(text[start:end:]))
            break

        if convert(text[start:end:]) not in stops:
            stops.append(convert(text[start:end:]))

        full_list[i].append(convert(text[start:end:]))

        prev_pos = end
        
    prev_pos = 0


for item in stops:
    query = "INSERT INTO megallo(nev) VALUES('{}')".format(item)

    print('Inserted stop:', item)

    cursor.execute(query)

    db.commit()

    for value in full_list.values():
        for i in range(len(value)):
            if value[i] == item:
                value[i] = cursor.lastrowid


for key, value in full_list.items():
    cursor.execute("INSERT INTO jarat(megnevezes, menetido, megallok_szama) VALUES('{}', {}, {})".format(routes[int(key)], int(1.5 * len(value)), len(value)))
    db.commit()

    print('Inserted route:', key)

    for i in range(len(value)):
        cursor.execute("INSERT INTO megall VALUES({}, '{}', {})".format(value[i], routes[int(key)], i + 1))
        db.commit()

        print('\tAssigned stopID', value[i], 'to route', key)        

print('DATABASE UPDATE DONE')