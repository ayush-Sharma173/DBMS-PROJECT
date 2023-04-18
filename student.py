import random
#("name","roll","10","12","cpi","age","br","aoi","yea","y/n","pack");

# company=("Google","Facebook","DeShaw","Uber","Sprinkler","Flipkart","Amazon")
# br=("AI","CS","MC","EE")
# post=("SDE","Quant","Finance","ML-Engineer","Data-Scientist","Consultant")
age=(18,19,20,21)
role=("SDE","Management","Quant","Consultancy","Core")
branch=("Computer_Science","AIDS","EEE","Chemical","MNC","MME")


sfile = open('stud_details.txt', 'w')

f = open("up.txt", "r")
entry=[]
for i in range(30):
        s=f.readline()
        fi=s.split('|')
        print(fi)
        # print(fi,file=sfile)
        en=[]
        s=""
        for c in fi:
            
            if c!="|" :
                    s=s+c
                    # print(s,file=sfile)  
            else:
                en.append(s)
                temp=s
                # print("replace",file=sfile)
                # print(s,file=sfile) 
                s=s.replace(s,"")
                # print(s,file=sfile) 

        entry.append(en)
        
print("insert into com_post values",file=sfile)
for en in entry:
    company=en[2]
    post=en[3]
    cpi=en[4]
    sal=en[1]
    qual=en[5]
    s='("'+company+'","'+post+'",'+sal+','+cpi+',"'+qual+'","'+"C1234567"+'"),'
    print(s,file=sfile)
        # print(en,file=sfile)




s=f.readline()
f=s.replace(" ","")
print(f,file=sfile)