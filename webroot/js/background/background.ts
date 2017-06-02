module background {
   class Node {
        static MIN_SIZE = .2;
        static MAX_SIZE = 10;
        static MIN_SPEED = 0;
        static MAX_SPEED = 2;
        static COLOR = "rgba(209, 124, 27, 1)";
        static COLOR_STOP = "rgba(209, 124, 27, 0)";
        static id = 0;

        size: number;
        dx: number;
        dy: number;
        color: string = Node.COLOR;
        id: number = Node.id++;
        mx: number = 0;
        my: number = 0;


        constructor(public x: number, public y: number) {
            this.setSize();
            this.setSpeed();
            this.x = x;
            this.y = y;
        }

        setSize() {
            this.size = (Math.random() * (Node.MAX_SIZE - Node.MIN_SIZE)) + Node.MIN_SIZE;
        }

        setSpeed() {
            this.dx = Math.random() > 0.5
                ?  -((Math.random() * (Node.MAX_SPEED - Node.MIN_SPEED)) + Node.MIN_SPEED)
                : (Math.random() * (Node.MAX_SPEED - Node.MIN_SPEED)) + Node.MIN_SPEED;
            this.dy = Math.random() > 0.5
                ?  -((Math.random() * (Node.MAX_SPEED - Node.MIN_SPEED)) + Node.MIN_SPEED)
                : (Math.random() * (Node.MAX_SPEED - Node.MIN_SPEED)) + Node.MIN_SPEED;
        }

        updateMouseMove(mx: number, my: number) {
            let xDiff = this.x - Background.mouseX;
            let yDiff = this.y - Background.mouseY;
            let length = Math.sqrt(Math.pow(xDiff, 2) + Math.pow(yDiff, 2))

            this.mx += (mx * 2/length);
            this.my += (my * 2/length);
        }

        update(maxX: number, maxY: number) {
            this.x = this.x + this.dx + this.mx;
            this.y = this.y + this.dy + this.my;
            this.my /= 1.5;
            this.mx /= 1.5;

            if (this.x >  maxX || this.x < 0) {
                this.dx *= -1;
            }
            if (this.y > maxY || this.y < 0) {
                this.dy *= -1;
            }

        }

        draw(ctx: CanvasRenderingContext2D) {
            let grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size/2);
            grad.addColorStop(0, Node.COLOR);
            grad.addColorStop(1, Node.COLOR_STOP);
            ctx.fillStyle = grad;
            ctx.fillRect(this.x - (this.size/2), this.y - (this.size/2), this.size, this.size);

            /*ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y ,this.size, 0, 2*Math.PI);
            ctx.fill();*/
        }
    }

    class BackgroundNode extends Node{
        static MIN_SIZE = 200;
        static MAX_SIZE = 800;
        static MIN_SPEED = 0;
        static MAX_SPEED = 2;
        static START_COLOR = "rgb(127,92,42)";
        static STOP_COLOR = "rgba(127,92,42,0)";

        draw(ctx: CanvasRenderingContext2D){
            let grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size/2);
            grad.addColorStop(0, BackgroundNode.START_COLOR);
            grad.addColorStop(1, BackgroundNode.STOP_COLOR);
            ctx.fillStyle = grad;
            ctx.fillRect(this.x - (this.size/2), this.y - (this.size/2), this.size, this.size);
        }

        setSize() {
            this.size = (Math.random() * (BackgroundNode.MAX_SIZE - BackgroundNode.MIN_SIZE)) + BackgroundNode.MIN_SIZE;
        }

        setSpeed() {
            this.dx = Math.random() < 0.5
                ?  -((Math.random() * (BackgroundNode.MAX_SPEED - BackgroundNode.MIN_SPEED)) + BackgroundNode.MIN_SPEED)
                : (Math.random() * (BackgroundNode.MAX_SPEED - BackgroundNode.MIN_SPEED)) + BackgroundNode.MIN_SPEED;
            this.dy = Math.random() < 0.5
                ?  -((Math.random() * (BackgroundNode.MAX_SPEED - BackgroundNode.MIN_SPEED)) + BackgroundNode.MIN_SPEED)
                : (Math.random() * (BackgroundNode.MAX_SPEED - BackgroundNode.MIN_SPEED)) + BackgroundNode.MIN_SPEED;
        }

    }

    class Link {
        static COLOR = "rgba(209, 124, 27, @@ALPHA@@)";

        constructor(public node1: Node, public node2: Node){

        }

        length(): number {
            let xDiff = this.node1.x - this.node2.x;
            let yDiff = this.node1.y - this.node2.y;
            return Math.sqrt(Math.pow(xDiff, 2) + Math.pow(yDiff, 2))
        }

        draw(ctx: CanvasRenderingContext2D) {
            ctx.strokeStyle =  ctx.strokeStyle = Link.COLOR.replace(/@@ALPHA@@/, '' + Math.max(0.2, (1 - this.length()/NodeList.LINE_SENSITIVITY)));
            ctx.beginPath();
            ctx.moveTo(this.node1.x, this.node1.y);
            ctx.lineTo(this.node2.x, this.node2.y);
            ctx.stroke();
        }
    }

    class NodeList {
        static MOUSE_SENSITIVITY = 400;
        static LINE_SENSITIVITY = 140;

        nodes: Array<Node> = [];
        canvas: HTMLCanvasElement;
        linkList: Array<Link> = [];
        bacgroundNodes: Array<BackgroundNode> = [];

        constructor(size: number, background_size: number, canvas: HTMLCanvasElement) {
            this.canvas = canvas;
            for (let i = 0; i < size; i++ ) {
                this.nodes.push(new Node(Math.random() * canvas.width, Math.random() * canvas.height));
            }
            for (let i = 0; i < background_size; i++) {
                this.bacgroundNodes.push(new BackgroundNode(Math.random() * canvas.width, Math.random() * canvas.height));
            }

        }

        mouseMove(dx: number, dy: number) {
            this.nodes.forEach(function(node){
                node.updateMouseMove(dx, dy);
            });
        }

        update() {
            for (let i = 0; i < this.bacgroundNodes.length; i++) {
                this.bacgroundNodes[i].update(this.canvas.width, this.canvas.height);
            }

            for (let i = 0; i < this.nodes.length; i++) {
                this.nodes[i].update(this.canvas.width, this.canvas.height);
                // Make sure the node is close to the cursor
                let xDiff = this.nodes[i].x - background.Background.mouseX;
                let yDiff = this.nodes[i].y - background.Background.mouseY;
                if (Math.sqrt(Math.pow(xDiff, 2) + Math.pow(yDiff, 2)) > NodeList.MOUSE_SENSITIVITY)continue;
                // Check if there is a close node
                for (let j = 0; j < this.nodes.length; j++) {
                    if (i == j)continue;
                    let xDiff = this.nodes[i].x - this.nodes[j].x;
                    let yDiff = this.nodes[i].y - this.nodes[j].y;
                    if (Math.sqrt(Math.pow(xDiff, 2) + Math.pow(yDiff, 2)) < NodeList.LINE_SENSITIVITY) {

                        if (!this.linksContains(this.nodes[i].id, this.nodes[j].id)) {
                            this.linkList.push(new Link(this.nodes[i], this.nodes[j]));
                        }
                    }
                }
            }

            // Remove links that are too long
            for (let i = 0; i < this.linkList.length; i++) {
                let xDiff1 = this.linkList[i].node1.x - background.Background.mouseX;
                let yDiff1 = this.linkList[i].node1.y - background.Background.mouseY;
                let xDiff2 = this.linkList[i].node2.x - background.Background.mouseX;
                let yDiff2 = this.linkList[i].node2.y - background.Background.mouseY;
                let mouseLength = Math.min(Math.sqrt(Math.pow(xDiff1, 2) + Math.pow(yDiff1, 2)), Math.sqrt(Math.pow(xDiff2, 2) + Math.pow(yDiff2, 2)));

                if (this.linkList[i].length() > NodeList.LINE_SENSITIVITY || mouseLength > NodeList.MOUSE_SENSITIVITY) {
                    this.linkList.splice(i, 1);
                    i--;
                }
            }
        }

        draw(ctx: CanvasRenderingContext2D){
            this.bacgroundNodes.forEach(function(backgroundNode) {
                backgroundNode.draw(ctx);
            });
            this.linkList.forEach(function(link) {
                link.draw(ctx);
            });
            this.nodes.forEach(function (node) {
                node.draw(ctx);
            });

        }

        linksContains(node1id: number, node2id: number): boolean  {
            for (let i = 0; i < this.linkList.length; i++) {
                if ((this.linkList[i].node1.id == node1id || this.linkList[i].node2.id == node1id)
                    && (this.linkList[i].node1.id == node2id || this.linkList[i].node2.id == node2id))return true;
            }
            return false;
        }
    }

    export class Background {
       static mouseX: number;
       static mouseY: number;
       static BACKGROUND_COLOR: string = '#423523';
       static NODE_NUM: number = 100;
       static BACKGROUND_NUM: number = 10;

        constructor(canvas: HTMLCanvasElement, options) {

            if (options != null) {
                if (options.base_color != null) {
                    let base_color: string = 'rgba(' + options.base_color.red + ', ' + options.base_color.green + ', ' + options.base_color.blue + ', ' + options.base_color.alpha + ')';
                    Node.COLOR = 'rgba(' +
                        options.base_color.red + ', ' +
                        options.base_color.green + ', ' +
                        options.base_color.blue + ', ' +
                        options.base_color.alpha + ')';
                    Node.COLOR_STOP = 'rgba(' +
                        options.base_color.red + ', ' +
                        options.base_color.green + ', ' +
                        options.base_color.blue + ', ' +
                        0 + ')';
                    BackgroundNode.START_COLOR = 'rgba(' +
                        Math.round(options.base_color.red/1.5) + ', ' +
                        Math.round(options.base_color.green/1.5) + ', ' +
                        Math.round(options.base_color.blue/1.5) + ', ' +
                        options.base_color.alpha + ')';
                    BackgroundNode.STOP_COLOR = 'rgba(' +
                        Math.round(options.base_color.red/1.5) + ', ' +
                        Math.round(options.base_color.green/1.5) + ', ' +
                        Math.round(options.base_color.blue/1.5) + ', ' +
                        0 + ')';
                    Link.COLOR = 'rgba(' +
                        options.base_color.red + ', ' +
                        options.base_color.green + ', ' +
                        options.base_color.blue +
                        ', @@ALPHA@@)';
                    Background.BACKGROUND_COLOR = 'rgba(' +
                        Math.round(options.base_color.red/2.5) + ', ' +
                        Math.round(options.base_color.green/2.5) + ', ' +
                        Math.round(options.base_color.blue/2.5) + ', ' +
                        options.base_color.alpha + ')';
                }
                if (options.mouse_sensitivity != null) NodeList.MOUSE_SENSITIVITY = options.mouse_sensitivity;
                if (options.point_num != null)Background.NODE_NUM = options.point_num;
                if (options.background_num != null)Background.BACKGROUND_NUM = options.background_num;

                if (options.links != null) {
                    if (options.links.color != null)Link.COLOR = options.links.color;
                    if (options.links.sensitivity != null)NodeList.LINE_SENSITIVITY = options.links.sensitivity;
                }
                if (options.background_shapes != null) {
                    if (options.background_shapes.min_size != null) BackgroundNode.MIN_SIZE = options.background_shapes.min_size;
                    if (options.background_shapes.max_size != null) BackgroundNode.MAX_SIZE = options.background_shapes.max_size;
                    if (options.background_shapes.min_speed != null) BackgroundNode.MIN_SPEED = options.background_shapes.min_speed;
                    if (options.background_shapes.max_speed != null) BackgroundNode.MAX_SPEED = options.background_shapes.max_speed;
                    if (options.background_shapes.center_color != null) BackgroundNode.START_COLOR = options.background_shapes.center_color;
                    if (options.background_shapes.edge_color != null) BackgroundNode.STOP_COLOR = options.background_shapes.edge_color;
                }
                if (options.forground_shapes != null) {
                    if (options.forground_shapes.min_size != null) Node.MIN_SIZE = options.forground_shapes.min_size;
                    if (options.forground_shapes.max_size != null) Node.MAX_SIZE = options.forground_shapes.max_size;
                    if (options.forground_shapes.min_speed != null) Node.MIN_SPEED = options.forground_shapes.min_speed;
                    if (options.forground_shapes.max_speed != null) Node.MAX_SPEED = options.forground_shapes.max_speed;
                    if (options.forground_shapes.center_color != null) Node.COLOR = options.forground_shapes.center_color;
                    if (options.forground_shapes.edge_color != null) Node.COLOR_STOP = options.forground_shapes.edge_color;
                }
            }

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            canvas.style.backgroundColor = Background.BACKGROUND_COLOR;
            Background.mouseX = window.innerWidth/2;
            Background.mouseY = window.innerHeight/2;

            let nodeList = new NodeList(Background.NODE_NUM, Background.BACKGROUND_NUM, canvas);

            window.onmousemove = function(e){
                nodeList.mouseMove(e.clientX - Background.mouseX, e.clientY - Background.mouseY);
                background.Background.mouseX = e.clientX;
                background.Background.mouseY = e.clientY;
            };
            window.setInterval(function() {
                canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
                nodeList.update();
                nodeList.draw(canvas.getContext("2d"));
            }, 50);
        }
    }
}