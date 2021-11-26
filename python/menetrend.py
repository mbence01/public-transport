import mysql.connector as sql

db = sql.connect(
    host = "localhost",
    user = "madranszki",
    password = "mB!2001!0906",
    database = "public-transport"
)

cursor = db.cursor()

school_season_start = '6:00'
school_season_end   = '16:00'

night_start = '19:00'

stops = {}
nodes = {}


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


def getStopList():
    for i in nodes.keys():
        cursor.execute('SELECT megallo.nev FROM megallo INNER JOIN megall ON megall.megallo_id = megallo.id WHERE megall.jarat_megnevezes = \'' + i + '\'')

        stops[i] = []

        for t in cursor.fetchall():
            stops[i].append(t[0])

    print(stops)


def doSchedule():
    start_time = 45

    for key, value in nodes.items():
        if value != 0:
            start_time /= value
            start_time = int(start_time)


        print('Key:', key, 'Time:', start_time)

        start_time = 45


getNodes()
getStopList()
doSchedule()