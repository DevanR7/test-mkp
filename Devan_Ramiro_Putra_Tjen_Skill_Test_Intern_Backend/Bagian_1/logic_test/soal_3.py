def print_clover_line(left_clovers, space, right_clovers):
    line = "*" * left_clovers + " " * space + "*" * right_clovers
    print(line)

# Baris pertama dan terakhir (21 clover)
print_clover_line(21, 0, 0)

# Baris kedua sampai ke-10 menggunakan logika pengulangan dan if/else
for i in range(1, 6):  # Baris 2-6
    if i == 1:
        print_clover_line(9, 2, 10)  # Baris 2
    elif i == 2:
        print_clover_line(8, 4, 9)  # Baris 3
    elif i == 3:
        print_clover_line(7, 6, 8)  # Baris 4
    elif i == 4:
        print_clover_line(6, 8, 7)  # Baris 5
    elif i == 5:
        # Baris 6 dengan strip
        print("*" * 5 + " " * 1 + "-" * 9 + " " * 1 + "*" * 5)

# Baris ketujuh sampai ke-10
for i in range(6, 11):  # Baris 7-10
    if i == 6:
        print_clover_line(6, 8, 7)  # Baris 7
    elif i == 7:
        print_clover_line(7, 6, 8)  # Baris 8
    elif i == 8:
        print_clover_line(8, 4, 9)  # Baris 9
    elif i == 9:
        print_clover_line(9, 2, 10)  # Baris 10

# Baris terakhir (21 clover)
print_clover_line(21, 0, 0)
