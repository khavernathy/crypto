import urllib
import time

def printf(format, *values):
    print(format % values )

# crypto
cryptos = {
    }

crypto_keys = {
    }

# read in holdings from assets.txt
filepath = 'assets.txt'  
f = open(filepath,'r')
for line in f:
    chunks = line.split()
    #print chunks
    if (len(chunks) == 2):
        chunks.append("")
    label = chunks[0]; holdings = chunks[1]; url = chunks[2];
    cryptos[label] = float(holdings)
    crypto_keys[label] = url
    


total_holds = 0.0;
total_crypto = 0.0;
printf("%10s  %15s    %10s    %7s", "Name", "Holdings", "Market val.", "Value")
for key in crypto_keys:
    link = crypto_keys[key]
    if (link != ""):   # don't do blank URLs
        #printf("doing key %10s\n",key)
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
        printf("%10s: %15s @ $%10s = $%8.4f", key, my_holds, value, this_hold)
        fname = str(key)+".txt"
        theline = str(time.strftime('%Y-%m-%dT%H:%M:%S')) + ".999    " + str(this_hold)
        with open(fname, "a") as coinfile:
            coinfile.write(theline+"\n")


theline = str(time.strftime('%Y-%m-%dT%H:%M:%S')) + ".999    " + str(total_crypto)
with open("crypto.txt", "a") as datafile:
    datafile.write(theline+"\n")


print ""
printf("Total cryptos  = ~$%8.2f",total_crypto)

# put however much USD you invested here
# cashed out 20.0 for Luci PSU, 40 for GPU
initial_invest = 1 # 50.0 + 70.0 + 75.0 + 26.0 + 200.0 - 20.0 - 40.0 + 50.0 + 50.0
print ""

printf("Total invested =  $%8.4f", initial_invest)
printf("Total gain     =  $%8.4f", total_holds - initial_invest)
printf("Gain factor    =   %8.4f", (total_holds)/initial_invest)
print str(time.strftime('Calculated on %m-%d-%Y at %H:%M:%S'))
print "======================================================="
print ""
print ""
