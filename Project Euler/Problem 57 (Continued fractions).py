import math

def add1((n,d)):
	return (n + d, d)

def flip((n,d)):
	return (d,n)

def gen_next(x):
	return add1(flip((add1(x))))

def repeat(n,f,x):
	if n == 0:
		return x
	else:
		return repeat(n - 1,f,f(x))

#print repeat(5,gen_next,(3,2))

i = 1
x = (3,2)
count = 0
while i <= 1000:
	(n,d) = x
	if int(math.log10(n)) > int(math.log10(d)):
		count += 1
		#print x
	x = gen_next(x)
	i += 1

print count
(n,d) = x

