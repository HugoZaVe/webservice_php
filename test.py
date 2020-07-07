import requests
import json
import base64


file = open('9786073187336.xml', 'r')
contenido = file.read()
file.close()
#print(type(contenido))

contenido_bytes = contenido.encode('utf-8')
contenido_base64 = base64.b64encode(contenido_bytes)

contenido_base64 = str(contenido_base64)

contenidoA = "'" + contenido + "'"

nameFile = '9786070757976.onix'

#contenido_decode = base64.b64decode(contenido_base64)
#contenido_end = contenido_decode.decode('utf-8')

#print(contenido_end)

#file = open('files/test.onix', 'w')
#try:
 #   print(file.write(contenido_end))
  #  pass
#finally:
 #   file.close()
  #  pass


#print(type(chain))

#print(chain)

dataInfo = {

    "usuario": 'Hugo Vega',
    "passwd": 'hola123',
    "nombre_archivo": '9786073187336ENCODE.xml',
    "archivo": contenido
}


#print(dataInfo['archivo'])

response = requests.post('http://localhost:8080/webservice/request.php', json = dataInfo)
print(response.text)

