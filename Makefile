PROJECT_NAME := santa-letter

docker:
	docker build -t $(PROJECT_NAME) .

run:
	./compose.py latest restart
