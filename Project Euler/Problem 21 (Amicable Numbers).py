
# coding: utf-8

# In[3]:

def divisor_sum(x):
    divisors=[]
    a=1
    while a<x**.5+1:
        if x%a==0:
            divisors.append(a)
        a=a+1 #Gets all the divisors less than the sqrt of x
    for d in divisors:
        if x/d not in divisors and d!=1: #The !=1 ensures we don't inclue the original number
            divisors.append(x/d) #Gets all the divisors larger than sqrt of x
    total=0
    #print divisors
    for d in divisors:
        total=total+d
    return total


# In[15]:

amicable_numbers=[]
c=1
while c<10000:
    if c==divisor_sum(divisor_sum(c)) and c!=divisor_sum(c) and c not in amicable_numbers: #Eliminates perfect numbers
        amicable_numbers.append(c)
        amicable_numbers.append(divisor_sum(c))
    c=c+1
print amicable_numbers
total=0
for a in amicable_numbers:
    total=total+a
print total


# In[17]:

c=1
while c<10000:
    if c==divisor_sum(divisor_sum(c)) and c!=divisor_sum(c) and c not in amicable_numbers: #Eliminates perfect numbers
        amicable_numbers.append(c)
        amicable_numbers.append(divisor_sum(c))
    c=c+1
print amicable_numbers


# In[21]:




# In[ ]:



