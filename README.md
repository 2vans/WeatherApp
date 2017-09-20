WeatherApp
==========

Baza danych:
  xampp:
  sudo service mysql stop
  Apache/2.4.25 (Unix) OpenSSL/1.0.2l PHP/7.1.6 mod_perl/2.0.8-dev Perl/v5.16.3
  PHP version: 7.1.6
  
  server:
   php bin/console s:start

parameters:
    database_host: 127.0.0.1
    database_port: 3306
    database_name: weather_app
    database_user: root
    database_password: null
    
    Potrzebuje chociaż jednego miasta: 
     
     city: Warsaw, Poland
     
     city:      Warsaw, Poland
     cond:      uknown
     temp:      0
     latitude:  52.2296756
     longitude: 21.0122287
    
    
    api.urls:
      base.url: 'http://query.yahooapis.com/v1/public/yql'
      base.yql: 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='



Korzystając z publicznie dostępnych usług sieciowych, stwórz aplikację, która będzie pobierała i wyświetlała w dowolnym miejscu strony informację na temat pogody w wybranym przez użytkownika mieście.

Aplikacja powinna umożliwiać:

  • Sprawdzenie przez każdego użytkownika stanu aktualnej pogody w wybranym z predefiniowanej listy mieście. W wypadku braku połączenia z zewnętrznymi usługami, wyświetlony powinien być ostatni stan pogody. Aplikacja powinna   umożliwiać odświeżenie informacji pogodowych bez przeładowania strony.

  •    Dla ograniczonej grupy użytkowników aplikacja powinna umożliwiać:
     o    Konfigurację adresu usługi sieciowej wykorzystywanej do pobierania danych pogodowych (np. yahoo).
     o    Edycję listy miast (dodawanie, usuwanie, zmiana) dla których możliwe jest sprawdzenie pogody

Zalecane jest, aby rozwiązanie umożliwiało rozszerzenie swojej funkcjonalności również na innych dostawców danych pogodowych.
Należy użyć framework’a Symfony, działającego na serwerze Apache i PHP w wersji > 7*. Możliwość użycia bibliotek firm trzecich.

Mile widziane:
   •    Stworzenie strony responsywnej (RWD)
   •    Wykorzystanie REST API.
   •    Implementacja mechanizmów zabezpieczających/walidacji poprawiających jakość przekazu informacji.
   
   
   sudo apt update -y && sudo apt upgrade -y && sudo apt install -y zsh guake tmux tmuxinator powerline mysql-client thunderbird php7.0 php7.0-mbstring php7.0-curl php7.0-mcrypt php7.0-xml php7.0-bcmath && sudo apt autoclean -y && sudo apt autoremove -y  
