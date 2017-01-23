
# coding: utf-8

# In[1]:

read_this= "Problem_13_Data.txt"
file_in = open(read_this, 'r')  #open is a function
all_lines= file_in.readlines()  # .readiness is a 'method.' Like a funciton but comes at the end.  
file_in.close() #important to close the file


# In[5]:

with open(read_this, 'r') as file_in:
    lines = file_in.readlines()
    file_in.close()


# In[57]:

###Can be ignored.  
solutions=[]
for line in lines:
    solutions.append([line[i:i+40] for i in range(0, len(line), 40)][1]) #THIS GIVES A LIST OF THE LAST 10 DIGITS OF EACH TERM.
s=0
total=0
while s<len(solutions):
    total=total+int(solutions[s])
    s=s+1
print total ###MISUNDERSTOOD THE QUESTION...


# In[60]:

s=0
total=0
while s<len(lines):
    total=total+int(lines[s])
    s=s+1
print total


# In[ ]:



