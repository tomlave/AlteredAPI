import requests
import json

SAVE_PATH = './Alt/'
SETNAME = 'ALIZE'
ItemPerPage = 36
Page = 7
headers = []
headers = {"Accept-Language":"fr-FR"}
for runPage in range(1,Page):
    response = requests.get('https://api.altered.gg/cards?cardSet[]='+SETNAME+'&ItemPerPage='+str(ItemPerPage)+'&page='+str(runPage), headers=headers)
    if response.status_code == 200:
        jsonFile = json.loads(response.text)
        for runCarte in range(ItemPerPage):
            TypeCarte = (jsonFile['hydra:member'][runCarte]['cardType']['name'])
            if TypeCarte != 'Jeton Personnage':
                NameJPG = (jsonFile['hydra:member'][runCarte]['collectorNumberFormatted'])
                LinkJPG = (jsonFile['hydra:member'][runCarte]['imagePath'])
                responseJPG = requests.get(LinkJPG,allow_redirects=True)
                #print(LinkJPG)
                if responseJPG.status_code == 200:
                    with open(SAVE_PATH+NameJPG+".png", 'wb') as f:
                        f.write(responseJPG.content)
