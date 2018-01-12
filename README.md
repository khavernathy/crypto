# crypto
a python API that tracks your crypto holdings values

# How to use

Do `bash run.sh` to get the script up-and-running. Every 5 minutes it will poll the web to get your current values. You can modify this increment in `run.sh` by changing `300` to whatever (in seconds).

Modify assets.py  to reflect your holdings for each coin (you can add new ones too). e.g. to add your holdings for PokeCoin (POKE), add

`"POKE" : 9001.0` to the `cryptos` array, and

`"POKE" : "https://coinmarketcap.com/currencies/pokecoin"` to the `crypto_keys` array.

You can modify `assets.py` at any time -- you don't have to re-start the program for changes to take effect.

Do `bash reset.sh` to reset all your holdings history (make sure you list your holdings in `reset.sh` as needed)

Do `bash view_crypto.sh` to see a graph of all holdings value in USD over time. This assumes you have `xmgrace` (http://plasma-gate.weizmann.ac.il/Grace/doc/UsersGuide.html) installed. If not, you can view the data with Excel or other software.

# Output stuff

The code outputs a neat table of your current holdings, market value, and USD value, and gives you a nice total. If you modify `initial_invest` to reflect your USD total investment, the `Gain factor` will display your net return on investment. e.g. `1.218` is a `21.8%` ROI.

lmk if u have questions

Dogelas
