import csv
from datetime import datetime, timedelta

class reservation:
    """
    Represents a reservation system for a restaurant.
    """

    def __init__(self):
        pass
    
    def display_option(self):
        """
        Displays the main menu of the reservation system.
        """

        print("\n\nRESTAURANT RESERVATION SYSTEM")
        print("System Menu:")
        print("1. View all Reservations\t2. Make Reservation")
        #print("3. Delete Reservation\t\t")
        print("3. Exit\n")

    def view_reservation(self):
        """
        Displays all existing reservations.
        """

        count = 0    
        with open('reservation.txt', 'r') as file:
            reader = csv.reader(file)
            header = next(reader)  # Skip the header row
            for row in reader:
                count +=1

        if count == 0:
            print("No reservation found.\n")
        else:
            file = open("reservation.txt", "r")
            print(file.read())
            file.close()

    def generate_time(self):
        """
        Generates time slots for reservations.

        Returns:
        - list: List of time slots.
        """

        start_time = datetime.strptime("16:00", "%H:%M")
        return [(start_time + timedelta(minutes=30 * i)).strftime("%I:%M %p") for i in range(0, 12)] #hour/minute/pm

    def display_slot(self,time_slot):
        """
        Displays available time slots for reservations.

        Parameters:
        - time_slot (list): List of time slots.
        """

        for i, time_slot in enumerate(time_slot, start=1):
                print(f"{i}: {time_slot}")

    def add_reservation(self):
        """
        Adds a new reservation based on user input.
        """

        name = input("Enter Name: ")
        phone = input("Phone number: ")

        # Generate 2 days in advance
        current_date = datetime.now()
        future_date1 = current_date + timedelta(days=1)
        future_date2 = current_date + timedelta(days=2)
        date1 = future_date1.strftime("%m/%d/%Y")
        date2 = future_date2.strftime("%m/%d/%Y")
        while True:
            date = input(f"Choose the day (Enter 1 or 2):\n1: {date1} \tor\t 2: {date2} \t:")
            print()
            try:
                if date == '1' or date == '2':
                    break
                else:
                    print("Invalid choice. Please enter a number 1 or 2.")
            except ValueError:
                print("Invalid input. Please enter a valid number.")

        time_slot = self.generate_time()
        self.display_slot(time_slot)

        while True:
            time_choice = input("Enter the number of your chosen time (1 to 12): ")

            try:
                if 0 <= int(time_choice) - 1 < 12:
                    time = time_slot[int(time_choice) - 1]
                    break
                else:
                    print("Invalid choice. Please enter a number between 1 and 12.")
            except ValueError:
                print("Invalid input. Please enter a valid number.")

        ppl = input("No. of People: ")
        file = open("reservation.txt", "a")
        if date == '1':
            file.write(f"{name:<14} {phone:<15} {date1:<13} {time:<14} {ppl:<13}\n")
        else:
            file.write(f"{name:<14} {phone:<15} {date2:<13} {time:<14} {ppl:<13}\n")
        file.close()
        print()

    def reservation(self):
        """
        Main method to interact with the reservation system.
        """
        while True:
            try:
                file = open("reservation.txt", "r")
            except FileNotFoundError:
                file = open("reservation.txt", "w+")
                file.write(f"{'Name':<15}{'Phone':<15}{'Date':<15}{'Time':<15}{'Adults':<10}\n")
            file.close()
            self.display_option()
            choice = input('Enter selection: ')
            if choice == '1': #View reservation
                self.view_reservation()
        
            elif choice == '2': #Add reservation
                self.add_reservation()
                
            elif choice == '3':
                import sys
                return

            else:
                print("Invalid response. Please try again.")