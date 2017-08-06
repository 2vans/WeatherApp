WeatherApp
==========



Korzystając z publicznie dostępnych usług sieciowych, stwórz aplikację, która będzie pobierała i wyświetlała w dowolnym miejscu strony informację na temat pogody w wybranym przez użytkownika mieście.

Aplikacja powinna umożliwiać:
  •    Sprawdzenie przez każdego użytkownika stanu aktualnej pogody w wybranym z predefiniowanej listy mieście. W wypadku braku połączenia z zewnętrznymi usługami, wyświetlony powinien być ostatni stan pogody. Aplikacja powinna   umożliwiać odświeżenie informacji pogodowych bez przeładowania strony.

  •    Dla ograniczonej grupy użytkowników aplikacja powinna umożliwiać:
     o    Konfigurację adresu usługi sieciowej wykorzystywanej do pobierania danych pogodowych (np. yahoo).
     o    Edycję listy miast (dodawanie, usuwanie, zmiana) dla których możliwe jest sprawdzenie pogody

Zalecane jest, aby rozwiązanie umożliwiało rozszerzenie swojej funkcjonalności również na innych dostawców danych pogodowych.
Należy użyć framework’a Symfony, działającego na serwerze Apache i PHP w wersji > 7*. Możliwość użycia bibliotek firm trzecich.

Mile widziane:
   •    Stworzenie strony responsywnej (RWD)
   •    Wykorzystanie REST API.
   •    Implementacja mechanizmów zabezpieczających/walidacji poprawiających jakość przekazu informacji.