
# coding: utf-8

# In[15]:

read_this= "Problem_18_Data.txt"
file_in = open(read_this, 'r')  #open is a function
all_lines= file_in.readlines()  # .readiness is a 'method.' Like a funciton but comes at the end.  
file_in.close() #important to close the file
with open(read_this, 'r') as file_in:
    lines = file_in.readlines()
    file_in.close()


# In[27]:

values=[]
for a in range(0,len(lines)):
    lines[a].split(",") #makes each line an entry
    lines[a].strip('\n') #removes \n
    values.append(lines[a].strip('\n'))
for a in range(0,len(values)):
    values[a]=values[a].split(" ") #makes each entry in each line its own string
for a in range(0,len(values)):
    for b in range(0,len(values[a])):
        values[a][b]=int(values[a][b]) #turns them from strings into integers


# In[ ]:




# In[42]:

values=[]
for a in range(0,len(lines)):
    lines[a].split(",") #makes each line an entry
    lines[a].strip('\n') #removes \n
    values.append(lines[a].strip('\n'))
for a in range(0,len(values)):
    values[a]=values[a].split(" ") #makes each entry in each line its own string
for a in range(0,len(values)):
    for b in range(0,len(values[a])):
        values[a][b]=int(values[a][b]) #turns them from strings into integers
#####################################################################################

i=0
j=len(values)-2 ##In this case, j_0=13. 
while j>=0:
    i=0
    while i<len(values[j]):
        sum_1=values[j][i]+values[j+1][i]
        sum_2=values[j][i]+values[j+1][i+1]
        if sum_1>sum_2:
            values[j][i]=sum_1
        if sum_2>sum_1:
            values[j][i]=sum_2
        i+=1
    j=j-1
values


# In[30]:




# In[ ]:

while i<len(values[13]):
    sum_1=values[13][i]+values[14][i]
    sum_2=values[13][i]+values[14][i+1]
    if sum_1>sum_2:
        values[13][i]=sum_1
    if sum_2>sum_1:
        values[13][i]=sum_2
    i+=1
