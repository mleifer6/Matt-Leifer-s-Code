
# coding: utf-8

# In[15]:

read_this= "Problem_42_Data.txt"
file_in = open(read_this, 'r')  #open is a function
all_lines= file_in.readlines()  # .readiness is a 'method.' Like a funciton but comes at the end.  
file_in.close() #important to close the file
with open(read_this, 'r') as file_in:
    lines = file_in.readlines()
    file_in.close()


# In[16]:

words=lines[0].split(",") 
words.sort()


# In[17]:

letter_values={'"':0,"A":1,'B':2,'C':3,'D':4,'E':5,'F':6,'G':7,'H':8,'I':9,'J':10,'K':11,'L':12,'M':13,'N':14,'O':15,'P':16,
               'Q':17,'R':18,'S':19,'T':20,'U':21,'V':22,'W':23,'X':24,'Y':25,'Z':26}


# In[82]:

word_scores=[]
count=0
while count<len(words):
    word_score=0
    word=words[count]
    for i in word:
        word_score=word_score+letter_values[i]
    word_scores.append(word_score)
    count=count+1
#print word_scores


# In[83]:

triangular_numbers=[int(x*(x+1)*.5) for x in range(1,21)]
print triangular_numbers


# In[99]:

answer=0
count=0
while count<len(word_scores):
    for t in triangular_numbers:
        if word_scores[count]==t:
            answer=answer+1
    count=count+1
print answer


# In[85]:




# In[ ]:



