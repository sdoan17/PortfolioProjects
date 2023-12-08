import socket
import threading
import sys
import protocol
from restaurant import Restaurant
from reservation import reservation

# Global variables
running = True
user_name = None
SH_Res = Restaurant()  # Instance of the Restaurant class
reso = reservation()  # Instance of the Reservation class


def delivery_takeout_option():
    """
    Displays and handles the delivery/takeout option for the user.

    Returns:
    - str: User's choice ('Take out' or 'Delivery')
    """
    while True:
        print("Option")
        print("1: To Takeaway")
        print("2: Delivery")
        try:
            option = input("Choose an option (1/2): ")
            if option =='1':
                return "Take out"
            elif option =='2':
                return "Delivery"
            else:
                print("Invalid option. Please choose 1 or 2.")
        except ValueError:
            print("Invalid input. Please enter a number.")


def get_valid_amount_input(price):
    """
    Gets a valid amount input from the user for payment.

    Parameters:
    - price: Total price of the items in the cart

    Returns:
    - float: Valid payment amount
    """
    while True:
        amount_input = input("Enter the amount to pay: ")
        try:
            amount = float(amount_input)
            if amount > price:
                return amount
            else:
                print("Error! Wrong amount. Please try again!\n")
        except ValueError:
            print("Error! Please enter a valid numeric amount.\n")


def check_out(client_socket):
    """
    Handles the check-out process for the user.

    Parameters:
    - client_socket: The socket object for communication with the server
    """ 
    try:
        if len(SH_Res.cart) == 0:
            print("\n You do not have any item in the cart!")
        else:
            SH_Res.showCart()
            price = SH_Res.calculateBill()
            SH_Res.receipt()
            amount = get_valid_amount_input(price)
            change = SH_Res.checkOut(amount)

            if change > 0:
                print(f"\nYour change is {change}")

            user_choice = delivery_takeout_option()
            full_name = input("Enter your full name: ")
            client_socket.send(full_name.encode('utf-8'))
            phone_number = input("Enter your phone number: ")
            client_socket.send(phone_number.encode('utf-8'))
            home_add = input("Home Address: ")
            client_socket.send(home_add.encode('utf-8'))
            time = client_socket.recv(1024).decode('utf-8')
            if user_choice == "Take out":
                print(f"\nYour order is ready in {time} minutes")
            else:
                print(f"\nYour delivery order is ready in {time} minutes")
            print('\nThank you for your purchase!\n')
    except Exception as e:
        print("Cannot send message")
        running = False

def get_valid_delete_input(cart_size):
    """
    Gets a valid item number for deletion from the cart.

    Parameters:
    - cart_size: Number of items in the cart

    Returns:
    - int: Valid item number for deletion
    """
    while True:
        try:
            print("\nEnter '0' to finish removing items.")
            item_number = int(input(f"Choose the item number you want to remove (1-{cart_size}): "))
            if item_number == 0:
                return 0
            elif 1 <= item_number <= cart_size:
                return item_number
            else:
                print("Invalid input. Please enter a number within the specified range.")
        except ValueError:
            print("Invalid input. Please enter a valid number.")

def delete_item_in_cart():
    """
    Handles the deletion of items from the user's cart.
    """
    try:
        if len(SH_Res.cart) == 0:
            print("\n You do not have any item in the cart!")
        else:
            SH_Res.showCart()
            cart_size = len(SH_Res.cart)
            item_number = get_valid_delete_input(cart_size)
            if item_number > 0:
                SH_Res.deleteItemInCart(item_number - 1)
    except Exception as e:
        print("Cannot send message")
        running = False

def get_valid_order_input(menu_len):
    """
    Gets a valid order input from the user for online ordering.

    Parameters:
    - menu_len: Number of items in the menu

    Returns:
    - int: Valid item number for ordering
    """
    while True:
        try:
            print("\nEnter '0' to finish ordering items.")
            order = int(input("Enter the number of the dish you want to order: "))
            if order == 0 or 1 <= order <= menu_len:
                return order
            else:
                print("Invalid Entry! Please enter a number within the menu.")
        except ValueError:
            print("Invalid Entry! Please enter a valid number.")

def handle_online_order():
    """
    Handles the online ordering process for the user.
    """
    try:
        SH_Res.displayMenu()
        SH_Res.showCart()
        ordering = True
        while ordering:
            menu_len = len(SH_Res.itemList)
            order = get_valid_order_input(menu_len)
            if order == 0:
                ordering = False
                break
            while True:
                amount = input("Enter the quantity: ")
                if amount.isdigit():
                    SH_Res.addItemToCart(order - 1, int(amount))
                    break
                else:
                    print("Invalid option! Please enter numeric amount")
    except Exception as e:
        print("Cannot send message")
        running = False

def process_user_choice(choice, client_socket):
    """
    Processes the user's choice and initiates corresponding actions.

    Parameters:
    - choice: User's menu choice
    - client_socket: The socket object for communication with the server
    """ 
    if choice == '1': #View Menu Only
        SH_Res.displayMenu()
    elif choice == '2': #Online Order
        handle_online_order()
    elif choice == '3': #View Cart
        SH_Res.showCart()
    elif choice == '4': #Delete item
        delete_item_in_cart()
    elif choice == '5': #Check out
        check_out(client_socket)
    elif choice == '6': #reservation
        reso.reservation()
    elif choice == '7': #cancel
        print("Call 77810000 to cancel your reservation!")
    elif choice == '8': #exsit
        running = False
        client_socket.send(choice.encode('utf-8'))
        client_socket.close()
        sys.exit()
    else:
        print("Invalid option. Please try again.")

def display_menu_options():
    """
    Displays the menu options for the user.
    """
    print("\nOPTION: ")
    print("1: View Menu")
    print("2: Online Order")
    print("3: View Your Cart")
    print("4: Delete item in cart")
    print("5: Check Out")
    print("6: Make reservation")
    print("7: Cancel Reservation")
    print("8: Quit")

def send_message(client_socket):
    """
    Sends user's choice to the server and initiates corresponding actions.

    Parameters:
    - client_socket: The socket object for communication with the server
    """
    global running
    while running:
        display_menu_options()
        choice = input("Select an option: ")
        if choice.isdigit() and 1 <= int(choice) <= 8:
            try:
                client_socket.send(choice.encode('utf-8'))
                process_user_choice(choice, client_socket)
            except Exception as e:
                print("Cannot send message")
                running = False
        else:
            print("\nInvalid option. Please try again.")

def main():
    global user_name
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    try:
        client_socket.connect(protocol.ADDR)
    except ConnectionRefusedError:
        sys.exit("Server is not running.")

    user_name = input("Enter your name: ")
    print(f"Hi {user_name}! Welcome to SH restaurant.")

    # Send the user's name to the server
    client_socket.send(user_name.encode('utf-8'))

    # Sending message thread
    send_thread = threading.Thread(target=send_message, args=(client_socket,))
    send_thread.daemon = True
    send_thread.start()

    send_thread.join()

if __name__ == '__main__':
    main()