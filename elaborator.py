from typing import List, Union
from time import sleep
import mysql.connector
from rich.progress import Progress
from rich.console import Console
from datetime import datetime, timedelta


class User:
    def __init__(self, data:tuple) -> None:
        self.id:int = data[0]
        self.gender:int = data[1]
        self.orientation:int = data[2]
        self.born:int = data[3]
        self.province:int = data[4]
        self.interests:List[int] = list()
        self.whatLookingFor:List[int] = list()
        self.userLiked:List[int] = list()
        self.userBlocked:List[int] = list()
    
    def addInterst(self, interes:int) -> None:
        self.interests.append(interes)
    
    def addWhatLookingFor(self, whatLookingFor:int) -> None:
        self.whatLookingFor.append(whatLookingFor)
    
    def addUserLiked(self, userLiked:int) -> None:
        self.userLiked.append(userLiked)
    
    def addUserBlocked(self, userBlocked:int) -> None:
        self.userBlocked.append(userBlocked)


class MatchElaborator:
    def __init__(self, console:Console) -> None:
        self.console = console
        self.database = mysql.connector.connect(host='127.0.0.1', user='root', password='', database='provaci_db')
        self.cursor = self.database.cursor()
    
    def getNumUsers(self) -> int:
        self.cursor.execute("SELECT COUNT(*) FROM user")
        return self.cursor.fetchone()[0]
    
    def getUsersId(self) -> List[int]:
        self.cursor.execute("SELECT id FROM user")
        return [user[0] for user in self.cursor.fetchall()]
    
    def getUser(self, id:int) -> User:
        self.cursor.execute(f"SELECT id, gender, orientation, YEAR(born), province FROM user WHERE id={id}")
        user = User(self.cursor.fetchone())
        
        self.cursor.execute(f"SELECT interest_id FROM user_interest WHERE user_id={id}")
        for interest in self.cursor.fetchall():
            user.addInterst(interest[0])
        
        self.cursor.execute(f"SELECT whatLookingFor_id FROM user_whatLookingFor WHERE user_id={id}")
        for whatLookingFor in self.cursor.fetchall():
            user.addWhatLookingFor(whatLookingFor[0])
        
        self.cursor.execute(f"SELECT userFrom_id FROM liked WHERE userTo_id={id}")
        for userLiked in self.cursor.fetchall():
            user.addUserLiked(userLiked[0])
        
        self.cursor.execute(f"SELECT userTo_id FROM blocked WHERE userFrom_id={id}")
        for userBlocked in self.cursor.fetchall():
            user.addUserBlocked(userBlocked[0])
        
        return user
    
    def elaborate(self, user1:User, user2:User) -> Union[int, bool]:
        # Contatore di compatibilità
        compatibility:int = 0

        # Controlla che l'utente1 non abbia bloccato l'utente2
        if user1.userBlocked.count(user2.id)>0:
            return False

        # Controlla se sono dello stesso orientamento, in caso affermativo controlla che questo non sia eterosessuale
        if user1.orientation==user2.orientation:
            if user1.orientation>1:
                compatibility += 20
            else:
                compatibility -= 20
        else:
            compatibility += 20
        
        # Controlla se le date di nascita sono vicine tra loro al massimo di 5 anni
        if abs(user1.born-user2.born)<=5:
            compatibility += 40
        
        # Controlla se i locali sono uguali
        if user1.province==user2.province:
            compatibility += 10
        
        # Controlla se gli interessi sono uguali
        for interest in user1.interests:
            if interest in user2.interests:
                compatibility += 15
        
        # Controlla se le cose che voglio sono uguali
        for whatLookingFor in user1.whatLookingFor:
            if whatLookingFor in user2.whatLookingFor:
                compatibility += 30
        
        # Controlla se all'utente2 piace l'utente1
        if user1.id in user2.userLiked:
            compatibility += 60
        

        if compatibility>=100:
            self.cursor.execute(f"INSERT INTO matched (userFrom_id, userTo_id, compatibility) VALUES ('{user1.id}', '{user2.id}', '{compatibility}')")
            self.database.commit()
            return compatibility
        else:
            return False

    def run(self) -> None:
        console.clear()
        with Progress(console=self.console) as progress:
            task1 = progress.add_task('User1', total=self.getNumUsers())
            task2 = progress.add_task('User2', total=self.getNumUsers()-1)

            for user1 in self.getUsersId():
                for user2 in self.getUsersId():
                    if user1==user2: continue
                    compatible = self.elaborate(self.getUser(user1), self.getUser(user2))
                    if compatible:
                        progress.log(f'[cyan]Compatible: {user1} -> {user2} ({compatible})')
                    progress.advance(task2, 1)
                    sleep(0.5)
                progress.advance(task1, 1)
                progress.reset(task2)
                progress.log(f'[green]User {user1} completed')


def waitTomorrow() -> None:
    t = datetime.now()+timedelta(days=1)
    tomorrow = datetime(t.year, t.month, t.day)
    while tomorrow>datetime.now():
        sleep(60)


if __name__=='__main__':
    try:
        console = Console()
        while True:
            match = MatchElaborator(console)
            match.run()
            waitTomorrow()
    except KeyboardInterrupt:
        pass
