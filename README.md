[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/CXISVZjE)
# VulnerableWEBApp

학습 목적으로 취약한 웹 애플리케이션 샘플을 코딩했습니다.

다음과 같은 악용 가능한 취약점이 있습니다.

- --> SQLI(Select, Update, Insert, Delete)
  - [로그인 우회 시 SQLI 선택]
  - [등록 프로세스 시 SQLI 삽입]
  - [프로필 업데이트 시 SQLI 업데이트, 비밀번호 변경]
  - [계정 삭제 시 SQLI 삭제]
  - [비밀번호 분실 시 블라인드 SQLI]

- --> 클릭재킹(프레임버스팅 기법, X-프레임 옵션 누락)
  - [sandbox="allow-forms"를 사용하여 악용 가능한 모든 페이지에서 프레임버스팅 사용]
  - [모든 페이지에서 X-프레임 옵션 누락]

- -->안전하지 않은 직접 객체 참조
  - [계정 삭제]
  - [비밀번호 변경]
  - [비밀번호 재설정]

- -->명령어 삽입
  - [|를 사용하여 명령어 삽입에 취약한 ping 기능] 명령을 연결할 수 있습니다]

- -->CSRF
  - [CSRF 토큰 누락]
  - [프로필 업데이트 중]

- -->XSS
  - [사용자 입력 인코딩/삭제 없음. 출력도 인코딩/삭제 없이 처리되어 XSS에 취약함]
  - [등록 중]
  - [설정 페이지]

- -->로컬 파일 포함(LFI):
  - (TOS 파일 포함 중)

## 서버 실행:

- 터미널에서 `php -S 0.0.0.0:8000`을 실행합니다.
- 이 새로운 포트에서 웹 앱에 액세스하려면 나타나는 알림에서 "브라우저에서 열기"를 클릭합니다.
  - '포트' 보기에서 전달된 포트의 정리된 표를 볼 수 있으며, **포트: 포트 보기에 집중** 명령으로 액세스할 수 있습니다.
  - '포트' 보기에서 포트 8000이 "Hello Remote World"라는 레이블이 지정되어 있습니다. `devcontainer.json`에서 전달된 포트의 레이블과 포트가 자동 전달될 때 수행할 작업과 같은 `"portsAttributes"`를 설정할 수 있습니다.
- 터미널을 다시 살펴보면 사이트 탐색의 출력이 표시되어야 합니다.

---

# VulnerableWEBApp

Coded a sample vulnerable web application for learning purpose..

It has following vulnerabilities which can be exploited

- --> SQLI (Select , Update , Insert, Delete)
  - [select SQLI in login bypass]
  - [Insert SQLI in Register process]
  - [Update SQLI in profile update , changing password]
  - [Delete SQLI in Deleting account]
  - [Blind SQLI in forgot password]

- --> Clickjacking (Framebursting technique, X-frame options missing)
  - [Framebursting is used in all the pages which can be exploited using sandbox="allow-forms" ]
  - [X-frame options missing in all pages]

- -->Insecure Direct Object reference
  - [Account deletion ]
  - [Password change]
  - [Password reset]

- -->Command Injection
  - [ping functionality vulnerable to command injection using | we can concatenate commands]

- -->CSRF
  - [ csrf token missing]
  - [while profile update]

- -->XSS
  - [No user input enconding/sanitizaion . output also without encoding/sanitization which is vulnerable to xss ]
  - [While registering]
  - [At setting page]

- -->Local File Inclusion (LFI) :
  - (While including TOS file)

## Running a server:

- From the terminal, run `php -S 0.0.0.0:8000`
- Click "Open in Browser" in the notification that appears to access the web app on this new port.
  - You can view an organized table of your forwarded ports in the 'Ports' view, which can be accessed with the command **Ports: Focus on Ports View**.
  - Notice port 8000 in the 'Ports' view is labeled "Hello Remote World." In `devcontainer.json`, you can set `"portsAttributes"`, such as a label for your forwarded ports and the action to be taken when the port is autoforwarded.
- Look back at the terminal, and you should see the output from your site navigations
