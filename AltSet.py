import requests
import json

SAVE_PATH = './ALIZE/'
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
                RarityJPG = (jsonFile['hydra:member'][runCarte]['rarity']['reference'])
                LinkJPG = (jsonFile['hydra:member'][runCarte]['imagePath'])
                responseJPG = requests.get(LinkJPG,allow_redirects=True)
                if TypeCarte == 'Héros':
                    JSON_HEROS.append(NameJPG)
                else:
                    if RarityJPG == 'COMMON':
                        JSON_CARDS_COMMON.append(NameJPG)
                    else:
                        JSON_CARDS_RARE.append(NameJPG)
                if responseJPG.status_code == 200:
                    with open(SAVE_PATH+NameJPG+".png", 'wb') as f:
                        f.write(responseJPG.content)
                        
print(JSON_HEROS)
print(JSON_CARDS_COMMON)
print(JSON_CARDS_RARE)
