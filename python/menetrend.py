import mysql.connector as sql

db = sql.connect(
    host = "localhost",
    user = "madranszki",
    password = "mB!2001!0906",
    database = "public-transport"
)

cursor = db.cursor()

nodes = {}
nodes_final = {}


def getNodes():
    cursor.execute('SELECT ' + 
                    'jarat_megnevezes, ' +  
                'COUNT(' + 
                        'case when (' + 
                            'SELECT COUNT(jarat_megnevezes) FROM megall WHERE megallo_id = m.megallo_id GROUP BY megallo_id' + 
                        ') > 5 then 1 else null end' +
                        ') AS csomopontok ' + 
                'FROM megall m ' + 
                'GROUP BY jarat_megnevezes')

    for t in cursor.fetchall():
        nodes[t[0]] = t[1]


def doSchedule():
    start_time = 60

    for key, value in nodes.items():
        if value != 0:
            start_time /= value
            start_time = int(_round(start_time))


        nodes_final[key] = start_time

        start_time = 60


def updateDatabase():
    curr_time = (4, 0)
    types = ('hétköznap', 'hétvége')

    for key, value in nodes_final.items():
        for i in range(2):
            while curr_time[0] < 22:
                minute = value

                if i == 1 and int(_round(value * 1.5)) < 61:
                    minute = int(_round(value * 1.5))

                curr_time = addMinToTime(curr_time, minute)

                print('Bus:', key, 'Day:', types[i], 'Time: {:02d}:{:02d}'.format(curr_time[0], curr_time[1]), 'inserted')

                insert_str = """INSERT INTO indul(indulasi_ora, indulasi_perc, indulasi_nap, jarat_megnevezes) VALUES(%s, %s, %s, %s)"""
                insert_tuple = ( curr_time[0], curr_time[1], types[i], key )

                cursor.execute(insert_str, insert_tuple)
                db.commit()

            curr_time = (4, 0)
            curr_type = 0


def _round(x, base = 5):
   return base * round(x / base)


def addMinToTime(time, min):
    hour = time[0]
    minute = time[1]

    if minute + min > 59:
        if hour + 1 > 23:
            hour = 0
        else:
            hour += 1

        minute = min - (60 - minute)
    else:
        minute += min

    return (hour, minute)


getNodes()
doSchedule()
updateDatabase()