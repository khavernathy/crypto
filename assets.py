import urllib
import time

def printf(format, *values):
    print(format % values )

# crypto
cryptos = {
    "XMR" : 0.216192426239, # homebox wallet
    "DOGE" : 7097.4211915, # homebox wallet
    "LTC" : 0.0950063300, # coinbase
    "ETH" : 0.1920, # coinbase
    "BTC" : 0.00050552, # coinbase
    "BCH" : 0.0096397, # coinbase
    "VTC" : 0.0000000, 
    "HTML" : 5499.0,  # mac (wallet)
    "MOON" : 6660.0,   # bleutrade
    "XMG" : 0.0,  # magicoin .. no wallet yet
    "GBX" : 0.00644602 # gobyte, mac wallet
    }

# stock
stocks = {
    "SBUX": 1.0,
    "AMD" : 5.0,
    "CVNA" : 2.0
}

crypto_keys = {
    "XMR" : "https://coinmarketcap.com/currencies/monero/",
    "DOGE" : "https://coinmarketcap.com/currencies/dogecoin/",
    "LTC" : "https://coinmarketcap.com/currencies/litecoin/",
    "ETH" : "https://coinmarketcap.com/currencies/ethereum/",
    "BTC" : "https://coinmarketcap.com/currencies/bitcoin/",
    "BCH" : "https://coinmarketcap.com/currencies/bitcoin-cash/",
    "VTC" : "https://coinmarketcap.com/currencies/vertcoin/",
    "HTML" : "https://coinmarketcap.com/currencies/htmlcoin/",
    "MOON" : "https://coinmarketcap.com/currencies/mooncoin/",
    "GBX" : "https://coinmarketcap.com/currencies/gobyte/"
    }

stock_keys = {
    "SBUX" : "http://www.nasdaq.com/symbol/sbux",
    "AMD" : "http://www.nasdaq.com/symbol/amd",
    "CVNA" : "http://www.nasdaq.com/symbol/cvna"
}

total_holds = 0.0;
total_crypto = 0.0;
printf("%10s  %15s    %10s    %7s", "Name", "Holdings", "Market val.", "Value")
for key in crypto_keys:
    link = crypto_keys[key]
    f = urllib.urlopen(link)
    myfile = f.read()
    my_holds = cryptos[key]
    fi = myfile.find("data-currency-value")
    chunk = myfile[fi+15:fi+30]
    fi2 = chunk.find(">")
    fi3 = chunk.find("<")
    value = chunk[fi2+1:fi3]
    this_hold = float(my_holds)*float(value)
    total_holds += this_hold
    total_crypto += this_hold
    printf("%10s: %15s @ $%10s = $%8.2f", key, my_holds, value, this_hold)
    fname = str(key)+".txt"
    theline = str(time.strftime('%Y-%m-%dT%H:%M:%S')) + ".999    " + str(this_hold)
    with open(fname, "a") as coinfile:
        coinfile.write(theline+"\n")

#print ""
#stocks_total = 0.0
#for key in stock_keys:
#    link = stock_keys[key]
#    f = urllib.urlopen(link)
#    myfile = f.read()
#    my_holds = stocks[key]
#    fi = myfile.find("qwidget-dollar")
#    chunk = myfile[fi+15:fi+30]
#    fi2 = chunk.find(">")
#    fi3 = chunk.find("<")
#    value = chunk[fi2+2:fi3]
#    this_hold = float(my_holds) * float(value)
#    total_holds += this_hold
#    stocks_total += this_hold
#    printf("%10s: %15s @ $%10s = $%8.2f", key, my_holds, value, this_hold)
#    fname = str(key) + ".txt"
#    theline = str(time.strftime('%m-%d-%YT%H:%M:%S')) + "    " + str(this_hold)
#    with open(fname, "a") as stockfile:
#        stockfile.write(theline+"\n")



#print time.strftime('%m-%d-%YT%H:%M:%S'), total_holds
theline = str(time.strftime('%Y-%m-%dT%H:%M:%S')) + ".999    " + str(total_crypto)
with open("crypto.txt", "a") as datafile:
    datafile.write(theline+"\n")

#theline = str(time.strftime('%m-%d-%YT%H:%M:%S')) + "    " + str(stocks_total)
#with open("stocks.txt", "a") as stockfile:
#    stockfile.write(theline+"\n")

#theline = str(time.strftime('%m-%d-%YT%H:%M:%S')) + "    " + str(total_holds)
#with open("total.txt", "a") as stockfile:
#    stockfile.write(theline+"\n")

print ""
printf("Total cryptos  = ~$%8.2f",total_crypto)
#printf("Total stocks   = ~$%8.2f",stocks_total)
#printf("Total holdings = ~$%8.2f",total_holds)

# initial investments. first 3 are stocks SBUX, AMD, CVNA
# next is BTC+LTC+ETH+BCH on coinbase
#initial_invest = 1.0*61.38 + 5.0*13.46 + 2.0*22.18
initial_invest = 70.0 + 75.0 + 26.0 + 200.0
print ""

printf("Total invested =  $%8.2f", initial_invest)
printf("Total gain     =  $%8.2f", total_holds - initial_invest)
printf("Gain factor    =   %8.3f", (total_holds)/initial_invest)
print str(time.strftime('Calculated on %m-%d-%Y at %H:%M:%S'))
print "======================================================="
print ""
print ""
