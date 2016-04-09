# for some reason that I don't understand at all this is somehow the instance directrly
sys.path.append(os.getcwd())
import sys
from const import *

sys.path.append(os.path.abspath(app_dir + '/domain'))


print("app_dir = " + app_dir)
print("instance_dir = " + instance_dir)
# print(sys.argv)
commandName = sys.argv[1]
# print(commandName)
# assert(commandName == 'ex')
if commandName != "ex":
    print('pyzn currently only handles one command: "ex"')
    sys.exit(1)
scriptName = sys.argv[2]
# print(scriptName)
scriptPath = app_dir + '/bin/' + scriptName + '.py'
args = sys.argv[2:]
exec(open(scriptPath).read())
