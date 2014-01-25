//
//  ViewController.m
//  脳トレ
//
//  Created by g-2015 on 2013/08/24.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import "ViewController.h"
#import "mainViewController.h"

@interface ViewController ()

@end

@implementation ViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    //音を鳴らす
    NSString *soundPath = [[NSBundle mainBundle] pathForResource:@"start_game" ofType:@"mp3"];
    NSURL *soundUrl = [NSURL fileURLWithPath:soundPath];
    titleSe = [[AVAudioPlayer alloc] initWithContentsOfURL:soundUrl error:nil];
    
    [titleSe prepareToPlay];
    
    seSwitch.on = _seOnOff;
    
    if(seSwitch.on){    //
        [titleSe play];
    }
    
    NSLog(@"_seOnOff,%d", _seOnOff);
    
    maxPointLabel.text = [NSString stringWithFormat:@"%d", _maxPoint];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)gameStartBtn:(id)sender {
    
}

- (IBAction)switchChanged:(id)sender {
    NSLog(@"SEスイッチが動いた");
}

//view移動したときの値渡しでつかう
-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    mainViewController *nextViewController = [segue destinationViewController];
    //ここで遷移先ビューのクラスの変数receiveStringに値を渡している
    nextViewController.seOnOff = seSwitch.on;
    nextViewController.maxPoint = _maxPoint;
}
@end
