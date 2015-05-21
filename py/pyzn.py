# print(os.getcwd())

constScript = os.getcwd() + '/const.py'
exec(open(constScript).read())
# print(app_dir)
# print(sys.argv)
commandName = sys.argv[1]
# print(commandName)
assert(commandName == 'ex')
scriptName = sys.argv[2]
# print(scriptName)
scriptPath = app_dir + '/bin/' + scriptName + '.py'
args = sys.argv[2:]
exec(open(scriptPath).read())
