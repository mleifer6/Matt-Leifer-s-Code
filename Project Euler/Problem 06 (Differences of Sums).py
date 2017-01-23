
# coding: utf-8

# In[4]:

#find the difference between the square of the sum of the first 100 numbers and the sum of their squares
a=1
b=1
sum_of_squares=0
normal_sum=0

while a<101:
    sum_of_squares=a**2+sum_of_squares
    a=a+1
while b<101:
    normal_sum=b+normal_sum
    b=b+1
print normal_sum 
print (normal_sum)**2-sum_of_squares


# In[ ]:



