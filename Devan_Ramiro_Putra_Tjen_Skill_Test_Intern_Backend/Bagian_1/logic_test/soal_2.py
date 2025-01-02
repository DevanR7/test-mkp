n = 5  # Jumlah bintang pada baris terluas

# Bagian atas 
for i in range(1, n, 2):  # i = 1, 3
    spaces = (n - i) // 2
    print(" " * spaces + "*" * i)

# Bagian bawah
for i in range(n - 2, 0, -2):  # i = 3, 1
    spaces = (n - i) // 2
    print(" " * spaces + "*" * i)
