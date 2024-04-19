#!C:\Users\parth\AppData\Local\Programs\Python\Python311\python.exe
print("Content-Type: text/html\n")

# import cgi
# form=cgi.FieldStorage()
# searchterm=form.getvalue('search_str')

import sys
argumentList=sys.argv
searchterm=argumentList[1]

from bs4 import BeautifulSoup
import requests
import json

def pharmeasy_scraper():
    url="https://pharmeasy.in/search/all?name=" + searchterm
    response=requests.get(url, timeout=5)
    content=BeautifulSoup(response.content, "html.parser")
    
    medArr=[]
    #ProductCard_medicineUnitWrapper__eoLpy ProductCard_defau1tWrapper__nxV0R
    #ProductCard_medicineUnitWrapper__eoLpy ProductCard_defaultWrapper__nxV0R
    # print(content.findAll('a'))

    for med in content.findAll('a', attrs={"class": "ProductCard_medicineUnitWrapper__eoLpy ProductCard_defaultWrapper__nxV0R"}):


        comp_name = med.find('div', attrs={"class": "ProductCard_brandName__kmcog"})
        if comp_name:
            comp_name = comp_name.text.strip()
        else:
            comp_name = "N/A"


        link = med.get('href')
        if link:
            link = "https://pharmeasy.in/" + str(link)
        else:
            link = "N/A"

        price_with_discount = med.find('span', attrs={"class": "ProductCard_striked__jkSiD"})
        discount = med.find('span', attrs={"class": "ProductCard_gcdDiscountPercent__oemCh"})
        
        if price_with_discount and discount:
            price = price_with_discount.text.strip()

            price = float(price[1:])
            discount = float(discount.text.strip()[:2])

            price_with_discount = price - (price * discount / 100.0)
            price_with_discount = round(price_with_discount, 2)
            
        elif med.find('div', attrs={"class": "ProductCard_ourPrice__yDytt"}):
            price_with_discount = med.find('div', attrs={"class": "ProductCard_ourPrice__yDytt"}).text[1:]
            if price_with_discount[-1] == "*":
                price_with_discount = price_with_discount[:-1]
            price_with_discount = float(price_with_discount)
        else:
            price_with_discount = "N/A"


        medobj={
            "source": "pharmeasy",
            "search_term": searchterm,
            "med_name": med.find('h1', attrs={"class": "ProductCard_medicineName__8Ydfq"}).text if med.find('h1', attrs={"class": "ProductCard_medicineName__8Ydfq"}) else "N/A",
            "comp_name": comp_name,
            "quantity": str(med.find('div', attrs={"class": "ProductCard_measurementUnit__hsZ2o"}).text) if med.find('div', attrs={"class": "ProductCard_measurementUnit__hsZ2o"}) else "N/A",
            "price": price_with_discount,
            "link" : link
            }
        
        
        with open("htmlfile.html", "wb") as htmlfile:
            htmlfile.write(str(med).encode('utf-8'))
        
        
        s=medobj["search_term"]
        i=s.find("'")
        s=s[i+1:]
        i=s.find("'")
        if(i!=-1):
            s=s[:i]
        medobj["search_term"]=s

        # p=medobj["price"]
        # p=p[29:]
        # i=p.find("<")
        # p=p[:i]
        # medobj["price"]=p
        
        # c=medobj["comp_name"]
        # c1=c[20:23]
        # c=c[31:]
        # i=c.find("<")
        # c=c1 + c[:i]
        # medobj["comp_name"]=c
        
        # q=medobj["quantity"]
        # q=q[20:]
        # i=q.find("<")
        # q=q[:i]
        # medobj["quantity"]=q
        
        medArr.append(medobj)

    with open("pharmeasy.json", "w") as ofile:
        json.dump(medArr, ofile)
    
    print("pharmeasy Script completed")
        
pharmeasy_scraper()

import subprocess
subprocess.call(["C:\\xampp\php\php.exe", "C:\\xampp\htdocs\Medbazaar\json_store.php"])
