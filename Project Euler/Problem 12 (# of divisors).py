
# coding: utf-8

# In[1]:
"""
###First Triangular number with over 500 divisors
number_of_divisors=1
solutions=[1]
while max(solutions)<500:
    #Calculates prime factors
    number_of_divisors=1
    a=.5*n*(n+1)
    divisor=2
    prime_factors=[]
    while divisor**2<=a:
        while a%divisor==0:        
            a=a/divisor
            prime_factors.append(divisor)
        divisor=divisor+1
    if a>1:
        prime_factors.append(a)
    #print prime_factors
    #Calculates number of divisors
    number_of_divisors=1
    index=0
    count=0
    while index<len(prime_factors):
        if prime_factors[index]!=prime_factors[index-1] or index==0:
            count=0
            check=0
            while check<len(prime_factors):
                if prime_factors[index]==prime_factors[check]:
                    count=count+1 #Count determines the number of times a factor appears.  
                check=check+1 #Cycles through the list of prime factors
            number_of_divisors=number_of_divisors*(count+1)
        index=index+1
    solutions.append(number_of_divisors)
    n=n+1
print .5*(n*(n-1))
"""

# In[2]:

def num_divisors(a):
    divisor=2
    prime_factors=[]
    while divisor**2<=a:
        while a%divisor==0:        
            a=a/divisor
            prime_factors.append(divisor)
        divisor=divisor+1
    if a>1:
        prime_factors.append(a)
    #print prime_factors
    number_of_divisors=1
    index=0
    count=0
    temp_dic={}
    while index<len(prime_factors):
        if prime_factors[index]!=prime_factors[index-1] or index==0:
            count=0
            check=0
            while check<len(prime_factors):
                if prime_factors[index]==prime_factors[check]:
                    count=count+1
                check=check+1
            number_of_divisors=number_of_divisors*(count+1)
            temp_dic.update({prime_factors[index]:count})
        index=index+1
    #print number_of_divisors
    #print temp_dic
    return number_of_divisors


# In[4]:
max_found = 0
candidate = 0
n = 1
while max_found < 500:
    tri = n * (n + 1) / 2
    d = num_divisors(tri)
    if max_found < d:
        max_found = d
        candidate = tri
    n += 1
print candidate, max_found



# In[3]:




# In[3]:




# In[ ]:



