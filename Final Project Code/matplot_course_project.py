import matplotlib
import matplotlib.pyplot as plt
import numpy as np

x = ("ND1", "ND2", "ND3", "ND4", "ND4L", "ND5", "ND6", "CO1", "CO2", "CO3", "ATP6", "ATP8", "CYB")

y = (165, 163, 38, 126, 29, 281, 96, 205, 113, 151, 266, 84, 298)

fig, ax = plt.subplots()

ax.plot(x,y)

ax.set(xlabel='MT Genes', ylabel = 'Number of Variants', title = 'Variants connected to disease in mitochondria protein coding genes')

ax.grid()

fig.savefig('mitoPlot.png')
