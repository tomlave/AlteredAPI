import requests
import os
import json

try:
    os.makedirs('./TBF')
except :
    pass

SAVE_PATH = './TBF/'
SETNAME = 'ALIZE'
ItemPerPage = 36
Page = 7
headers = []
headers = {"Accept-Language":"fr-FR"}
JSON_HEROS = []
JSON_CARDS_COMMON = []
JSON_CARDS_RARE = []
for runPage in range(1,Page):
    response = requests.get('https://api.altered.gg/cards?cardSet[]='+SETNAME+'&ItemPerPage='+str(ItemPerPage)+'&page='+str(runPage), headers=headers)
    if response.status_code == 200:
        jsonFile = json.loads(response.text)
        for runCarte in range(ItemPerPage):
            try:
                TypeCarte = (jsonFile['hydra:member'][runCarte]['cardType']['name'])
            except:
                break
            if TypeCarte != 'Jeton Personnage':
                NameJPG = (jsonFile['hydra:member'][runCarte]['collectorNumberFormatted'])
                ReferenceJPG = (jsonFile['hydra:member'][runCarte]['reference'])
                RarityJPG = (jsonFile['hydra:member'][runCarte]['rarity']['reference'])
                DataFaction = (jsonFile['hydra:member'][runCarte]['mainFaction']['reference'])
                DataName = (jsonFile['hydra:member'][runCarte]['name'])
                DataMain = (jsonFile['hydra:member'][runCarte]['elements']['MAIN_COST'])
                if DataMain[0] == '#':
                    DataMain = DataMain[1]
                DataRecall = (jsonFile['hydra:member'][runCarte]['elements']['RECALL_COST'])
                if DataRecall[0] == '#':
                    DataRecall = DataRecall[1]
                #DataName = (jsonFile['hydra:member'][runCarte]['elements']['OCEAN_POWER'])
                #DataName = (jsonFile['hydra:member'][runCarte]['elements']['FOREST_POWER'])
                #DataName = (jsonFile['hydra:member'][runCarte]['elements']['MOUNTAIN_POWER'])

                LinkJPG = (jsonFile['hydra:member'][runCarte]['imagePath'])
                responseJPG = requests.get(LinkJPG,allow_redirects=True)
                if TypeCarte == 'Héros':
                    JSON_HEROS.append([NameJPG,DataFaction,DataName,DataMain,DataRecall,ReferenceJPG])
                else:
                    if RarityJPG == 'COMMON':
                        JSON_CARDS_COMMON.append([NameJPG,DataFaction,DataName,DataMain,DataRecall,ReferenceJPG])
                    else:
                        JSON_CARDS_RARE.append([NameJPG,DataFaction,DataName,DataMain,DataRecall,ReferenceJPG])
                if responseJPG.status_code == 200:
                    with open(SAVE_PATH+NameJPG+".png", 'wb') as f:
                        f.write(responseJPG.content)

with open("heros.json", 'w') as h:
    json.dump(JSON_HEROS,h)
with open("common.json", 'w') as c:
    json.dump(JSON_CARDS_COMMON,c)
with open("rare.json", 'w') as r:
    json.dump(JSON_CARDS_RARE,r)
