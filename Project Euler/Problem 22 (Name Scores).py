
# coding: utf-8

# In[2]:

read_this= "Problem_22_Data.txt"
file_in = open(read_this, 'r')  #open is a function
all_lines= file_in.readlines()  # .readiness is a 'method.' Like a funciton but comes at the end.  
file_in.close() #important to close the file
with open(read_this, 'r') as file_in:
    lines = file_in.readlines()
    file_in.close()


# In[100]:

names=lines[0].split(",") 
names.sort()


# In[101]:

letter_values={'"':0,"A":1,'B':2,'C':3,'D':4,'E':5,'F':6,'G':7,'H':8,'I':9,'J':10,'K':11,'L':12,'M':13,'N':14,'O':15,'P':16,
               'Q':17,'R':18,'S':19,'T':20,'U':21,'V':22,'W':23,'X':24,'Y':25,'Z':26}


# In[102]:

total_score=0
count=0
while count<len(names):
    name_score=0
    name=names[count]
    for i in name:
        name_score=name_score+letter_values[i]
    total_score=total_score+(name_score*(count+1))
    count=count+1
print total_score


# In[103]:

name=names[100]
score=0
for i in name:
    score=score+letter_values[i]


# In[104]:

names[939]


# In[ ]:



