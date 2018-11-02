#import urllib
# u need requests and pandas libraries
# i installed via 
# sudo easy_install -U [requests/pandas]
import requests
import pandas
url = "https://miningpoolhub.com/index.php?page=api&action=getminingandprofitsstatistics"
r = requests.get(url, headers={'Accept': 'application/json'})
data = pandas.DataFrame(r.json())
#print(data.head())

coinlist = []

for i, row in data.iterrows():
    #print row[0]
    coinlist.append(tuple((row[0]['coin_name'], row[0]['normalized_profit_nvidia'])))

def getKey(item):
    return item[1]

coinlist = sorted(coinlist, key=getKey, reverse=True)

#match = [("ethereum-classic", "ETC"),("ethereum", "ETH"),("musicoin", "MUSIC"),("expanse", "EXP"),("monero", "XMR",("feathercoin", "FTC"),("digibyte-skein", "DGB"),("zcoin", "XZC"),("zcash", "ZEC"),("zencash", "ZEN"),("zclassic", "ZCL"),("maxcoin", "MAX"),("myriadcoin-skein", "XMY"),("monacoin", "MONA"),("vertcoin", "VTC"),("myriadcoin-yescrypt", "XMY"), ("globalboosty", "BSTY"),("digibyte-groestl", "DGB"),("groestlcoin", "GRS"),("myriadcoin-groestl", "XMY"),("digibyte-qubit", "DGB"),("litecoin", "LTC"),("gamecredits", "GAME"),("verge-scrypt", "XVG"),("dash", "DASH"),("siacoin", "SC"), ("bitcoin-cash", "BCH"),("bitcoin-gold", "BTG"),("electroneum", "ETN"),("sexcoin", "SXC"),("auroracoin-qubit", "AUR"),("bitcoin", "BTC"),("startcoin", "START"),("adzcoin", "ADZ"),("ethersocial", "ESN")]

for i in coinlist:
    print i[0], i[1]



#link = "https://miningpoolhub.com/"
#f = urllib.urlopen(link)
#myfile = f.read()
#print(myfile)
