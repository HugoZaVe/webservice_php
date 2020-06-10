import requests
import json
import base64


file = open('files/9786070757976.onix', 'r')
contenido = file.read()
print(type(contenido))

contenido_bytes = contenido.encode('utf-8')
contenido_base64 = base64.b64encode(contenido_bytes)


contenido_decode = base64.b64decode(contenido_base64)
contenido_end = contenido_decode.decode('utf-8')

print(contenido_end)

file = open('files/test.onix', 'w')
try:
    print(file.write(contenido_end))
    pass
finally:
    file.close()
    pass


#print(type(chain))

#print(chain)

data = {

    'usuario': 'tufan',
    'passwd': 'hola',
    'editorial': 'tunerd',
    'archivo': contenido_base64,
    'name_archivo': '9786070757976.onix'
}

