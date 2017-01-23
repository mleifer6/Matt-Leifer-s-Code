
# coding: utf-8

# In[1]:

read_this= "Problem_99_Data.txt"
file_in = open(read_this, 'r')  #open is a function
all_lines= file_in.readlines()  # .readiness is a 'method.' Like a funciton but comes at the end.  
file_in.close() #important to close the file
with open(read_this, 'r') as file_in:
    lines = file_in.readlines()
    file_in.close()


# In[4]:

values=[]
for a in range(0,len(lines)):
    lines[a].split(",") #makes each line an entry
    lines[a].strip('\n') #removes \n
    values.append(lines[a].strip('\n'))
i=0
while i<len(values): 
    values[i]=values[i].split(",") #puts each pair in its own mini list
    i+=1


# In[26]:

j=0
while j<len(values):
    values[j][0]=int(values[j][0])
    values[j][1]=int(values[j][1])
    j+=1


# In[35]:

def ln(x):
    import math
    return math.log(x)


# In[40]:

largest=0
k=0
line=0
while k<len(values):
    if values[k][1]*ln(values[k][0])>largest:
        largest=values[k][1]*ln(values[k][0])
        line=k
    k+=1
print line


# In[38]:




# In[ ]:



