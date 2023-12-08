import socket
import threading
import protocol
import sys
from restaurant import Restaurant
import random

# Global variables
running = True
clients = []  # List to store client sockets
clients_lock = threading.Lock()  # Lock for thread-safe access to the 'clients' list
customer_info = {}  # Dictionary to store customer information
SH_Res = Restaurant()  # Instance of the Restaurant class


def client_handle(client_socket, addr):
    """
    Handles communication with a client.

    Parameters:
    - client_socket: The socket object for the client connection
    - addr: The address (IP, port) of the client

    This function receives messages from the client and performs actions based on the received option.
    """

    global clients, customer_info
    print(f"\n[+] New connection from {addr}")

    with clients_lock:
        clients.append(client_socket)

    name = client_socket.recv(1024).decode('utf-8')
    print(f"{name} just logged in")

    try:
        while True:
            option = client_socket.recv(1024).decode('utf-8')
            if option == '1':
                print(f"Client {addr} is looking at the menu")
            elif option == '2':
                print(f"Client {addr} is ordering food online")
            elif option == '3':
                print(f"Client {addr} is looking at their cart")
            elif option == '4':
                print(f"Client {addr} is modifying their cart")
            elif option == '5':
                print(f"Client {addr} is in the process of checking out")
                full_name = client_socket.recv(50).decode('utf-8')
                print(f"Received full name: {full_name}")
                phone_number = client_socket.recv(50).decode('utf-8')
                print(f"Received phone number: {phone_number}")
                home_add = client_socket.recv(50).decode('utf-8')
                print(f"Received home address: {home_add}")
                customer_info[addr] = {'full_name': full_name, 'phone_number': phone_number, 'home_add' : home_add}  
                time = random.randint(15, 30)
                str_time = str(time)
                client_socket.send(str_time.encode('utf-8'))
                print(f"Client {addr} paid")

            elif option == '6':
                print(f"Client {addr} is making a reservation")
            elif option == '7':
                print(f"Client {addr} is canceling their reservation")
            else:
                print("See you again!!")
                break
    except ConnectionResetError:
        print(f"[-] Connection reset by {addr}")
    except Exception as e:
        print(f"[!] An exception occurred with {addr}: {e}")
    finally:
        with clients_lock:
            if client_socket in clients:
                clients.remove(client_socket)
        client_socket.close()
        print(f"[-] Connection from {addr} has been closed.")


def shutdown_server(server):
    """
    Shuts down the server and closes all client connections.

    Parameters:
    - server: The server socket object

    This function sends a shutdown message to all connected clients and then closes the server.
    """
    
    global running, clients
    running = False
    with clients_lock:
        for client in clients:
            try:
                client.send("Server is shutting down.".encode('utf-8'))
                client.close()
            except Exception as e:
                print(f"Error closing client socket: {e}")

        server.close()
        print("[*] Server has been shut down.")
        sys.exit()

# main
def main():
    global running
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    #server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server_socket.bind(protocol.ADDR)
    server_socket.listen(10) # server 10 customers at 1 time
    print(f"[*] Server is listening on {protocol.ADDR}")

    def shutdown_command():
        global running
        while running:
            shutdown = input("Enter 'q' to quit: ")
            if shutdown.lower() == "q":
                shutdown_server(server_socket)
        
    shutdown_thread = threading.Thread(target=shutdown_command)
    shutdown_thread.daemon = True
    shutdown_thread.start()

    try:
        while running:
            client_socket, addr = server_socket.accept()
            client = threading.Thread(target=client_handle, args=(client_socket,addr))
            client.daemon = True
            client.start()
    except Exception as e:
        print(f"Server error: {e}")
    finally:
        if running:
            shutdown_server(server_socket)



    
if __name__ == "__main__":
    main()

