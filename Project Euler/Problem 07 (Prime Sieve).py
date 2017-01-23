
# coding: utf-8

# In[1]:

x= input() 
numbers=range(2,x+1,1)
count=0
while count<len(numbers):
    for n in numbers:
        if n%numbers[count]==0 and n!=numbers[count]:
            numbers.remove(n)
    count=count+1
print numbers
#this took 59 seconds to get all the primes less than 100,000. 


# In[1]:

x= input() 
numbers=range(2,x+1,1)
count=0
while count<len(numbers):
    for n in numbers:
        if n%numbers[count]==0 and n!=numbers[count]:
            numbers.remove(n)
    count=count+1
print numbers


# In[ ]:



