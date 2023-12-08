class Restaurant:
    """
    Represents a restaurant with a menu and shopping cart functionality.

    Attributes:
    - itemList (list): List of items for easy access.
    - cart (list): List to store items in the user's shopping cart.
    - menu (dict): Dictionary containing menu items with prices and descriptions.
    """

    def __init__(self):
        """
        Initializes a new instance of the Restaurant class.
        """

        self.itemList = ['Tuna Stack', 'Steak Mushroom', 'Chicken Truffle', '6 Layers Chocolate', 'Midnight Hour', 'Moscow Mule', 'Sunset Soda'] # for esay access
        self.cart = []
        self.menu= {
            'Tuna Stack': {
                'Price': 21.25,
                'Description': 'Ocean wise™ ahi, citrus tamari vinaigrette, nori, sesame, avocado, microgreens, wonton crisps'
            },
            'Steak Mushroom': {
                'Price': 38.75,
                'Description': '8oz CAB® sirloin, grilled oyster mushrooms, button mushrooms, red wine jus, buttered mashed potatoes, seasonal vegetables'
            },
            'Chicken Truffle': {
                'Price': 31.00,
                'Description': 'Parmesan crusted chicken breast, roasted and grilled mushrooms, potato gnocchi, truffle mushroom cream sauce, arugula'
            },
            '6 Layers Chocolate': {
                'Price': 18.00,
                'Description': 'Tahitian vanilla ice cream, cherry made to share'
            },
            'Midnight Hour': {
                'Price': 15.00,
                'Description': 'Espresso martini with smirnoff vodka, kahlua, fresh espresso, chocolate bitters (2oz)'
            },
            'Moscow Mule': {
                'Price': 12.75,
                'Description': 'Smirnoff vodka, fresh squeezed lime, ginger beer, served in a copper cup with grey goose +3 (1oz)'
            },
            'Sunset Soda': {
                'Price': 10.00,
                'Description': 'Smirnoff orange vodka, soda, bellini slush (1oz)'
            }
    }


    def displayMenu(self):
        """
        Displays the restaurant menu with item details.
        """

        print("\n\nMenu")
        print("==================================")

        for index, (item, details) in enumerate(self.menu.items()):
            print(f"{index+1} : {item}")
            print(f"  Price: ${details['Price']}")
            print(f"  Description: {details['Description']}")
            print("==================================")


    def addItemToCart(self, order, amount):
        """
        Adds an item and its quantity to the user's shopping cart.

        Parameters:
        - order (int): Index of the item in the itemList.
        - amount (int): Quantity of the item to be added.
        """

        item = self.itemList[order] #to get the item from the list
        if len(self.cart) == 0:
            self.cart.append([item, amount])
        else:
            found = False
            for order in self.cart:
                if order[0] == item:  # to check if the item is already in the cart
                    order[1] += amount
                    found = True
                    break
            
            if found == False:
                self.cart.append([item, amount])
        
    def showCart(self):
        """
        Displays the items and quantities in the user's shopping cart.
        """
        if len(self.cart) == 0:
            print("\nYour Cart is Empty!")
        else:
            print("\nYour Cart: ")
            for i, order in enumerate(self.cart):
                print(f"{i+1}: {order[0]} - Quantity: {order[1]}")

    def calculateBill(self):
        """
        Calculates the total price of items in the user's shopping cart.

        Returns:
        - float: Total price of items in the cart.
        """

        price = 0.0
        for order in self.cart:
            item = order[0]
            quantity = order[1]
            
            price += self.menu[item]['Price'] * quantity 
     
        return price

    def checkOut(self, amount):
        """
        Processes the checkout, calculates the change, and resets the cart.

        Parameters:
        - amount (float): The amount paid by the user.

        Returns:
        - float: Change to be given to the user.
        """

        price = self.calculateBill()
        self.resetCart()
        return amount-price

    def deleteItemInCart(self, item_number):
        """
        Deletes an item from the user's shopping cart.

        Parameters:
        - item_number (int): Index of the item to be removed from the cart.
        """

        removed_item = self.cart.pop(item_number)
        print(f"Removed {removed_item[0]} from the cart.")
        self.showCart()

    def resetCart(self):
        """
        Resets the user's shopping cart.
        """
        self.cart=[]

    def receipt(self):
        """
        Generates a receipt based on the items in the user's cart.

        Returns:
        - str: Receipt containing details of the items ordered and the total cost.
        """

        print("\nReceipt\n\nItem Ordered:\n\n")

        for order in self.cart:
            item = order[0]
            quantity = order[1]
            print(f"{item} - Quantity: {quantity}")
            print(f"Price per unit: ${self.menu[item]['Price']:.2f}")
            print("==================================")

        print("\nSubtotal:", str(self.calculateBill()))
        print("Thank you for your purchase!\n")

    